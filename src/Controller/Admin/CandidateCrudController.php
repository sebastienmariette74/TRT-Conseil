<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Candidate;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CandidateCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Candidate::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Candidats')
            ->setEntityLabelInSingular('candidat')
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
            Field::new('password', 'Mot de passe')
                ->onlyWhenUpdating()
                ->setRequired(false),
            Field::new('password', 'Mot de passe')
                ->setFormType(PasswordType::class)
                ->onlyWhenCreating(),
            TextField::new('firstname', 'Prénom')
                ->setRequired(false),
            TextField::new('lastname', 'Nom')
                ->setRequired(false),
            TextField::new('cv', 'CV')
                ->setRequired(false),
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
            BooleanField::new('isVerified', 'Vérifié')
                ->onlyOnForms(),       
            BooleanField::new('isActivated', 'Activé')
                ->onlyOnForms(),    
            ImageField::new('cv')
                ->hideOnIndex()
            //     ->setBasePath('uploads/') 
                ->setUploadDir('assets/uploads')
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
