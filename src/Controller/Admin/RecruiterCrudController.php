<?php

namespace App\Controller\Admin;

use App\Entity\Recruiter;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class RecruiterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recruiter::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Recruteurs')
            ->setEntityLabelInSingular('recruteur')
            ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Id')
                ->hideOnForm(),
            EmailField::new('email', 'Email'),     
            EmailField::new('email', 'Email')
                ->onlyWhenUpdating()     
                ->setFormTypeOption('disabled', 'disabled'),
            EmailField::new('email', 'Email') 
                ->onlyWhenCreating(),
            Field::new('password' , 'Saisir le mot de passe actuel ou un nouveau')
                ->setFormType(PasswordType::class)
                ->onlyWhenUpdating()
                ->setRequired(false),
            Field::new('password', 'Mot de passe')
                ->setFormType(PasswordType::class)
                ->onlyWhenCreating(),
            TextField::new('name', 'Nom'),
            TextField::new('address', 'Adresse'),
            TextField::new('zipcode', 'Code Postal'),
            TextField::new('city', 'Ville'),
            ChoiceField::new('roles')
                ->renderExpanded()
                ->autocomplete()
                ->allowMultipleChoices()
                ->setChoices([
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_CANDIDATE' => 'ROLE_CANDIDATE',
                    'ROLE_RECRUITER' => 'ROLE_RECRUITER',
                    'ROLE_CONSULTANT' => 'ROLE_CONSULTANT'
                ]),
            BooleanField::new('isVerified', 'V??rifi??')
                ->onlyOnForms(),       
            BooleanField::new('isActivated', 'Activ??')
                ->onlyOnForms()     
        ];
    }

    public function createEditFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createEditFormBuilder($entityDto, $formOptions, $context);

        $this->addEncodePasswordEventListener($formBuilder);

        return $formBuilder;
    }

    public function createNewFormBuilder(EntityDto $entityDto, KeyValueStore $formOptions, AdminContext $context): FormBuilderInterface
    {
        $formBuilder = parent::createNewFormBuilder($entityDto, $formOptions, $context);

        $this->addEncodePasswordEventListener($formBuilder);

        return $formBuilder;
    }

    /**
     * @required
     */
    public function setEncoder(UserPasswordHasherInterface $passwordEncoder): void
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    protected function addEncodePasswordEventListener(FormBuilderInterface $formBuilder)
    {
        $formBuilder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            /** @var User $user */
            $user = $event->getData();
            if ($user->getPassword()) {
                $user->setPassword(
                    $this->passwordEncoder->hashPassword(
                        $user,
                        $user->getPassword()
                    )
                );
            }
        });
    }
}
