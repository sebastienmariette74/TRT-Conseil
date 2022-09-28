<?php

namespace App\Controller\Admin;

use App\Entity\JobOffer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class JobOfferCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return JobOffer::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Offres d\'emploi')
            ->setEntityLabelInSingular('Offre d\'emploi')
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')
                ->setLabel('Id')
                ->hideWhenCreating()
                ->setFormTypeOption('disabled', 'disabled'),
            AssociationField::new('recruiter')
                ->setLabel('Recruteur')
                ->setFormTypeOption('choice_label', 'email')
                ->hideWhenUpdating(),
            TextField::new('recruiter.email')
                ->setLabel('Recruteur')
                ->onlyWhenUpdating()
                ->setFormTypeOption('disabled', 'disabled'),
            TextField::new('title')
                ->setLabel('Intitulé'),
            TextField::new('city')
                ->setLabel('Ville'),
            TextEditorField::new('description')
                ->setLabel('Description'),
        ];
    }
    
}
