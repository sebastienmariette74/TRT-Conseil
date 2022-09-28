<?php

namespace App\Controller\Admin;

use App\Entity\Application;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class ApplicationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Application::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Candidatures')
            ->setEntityLabelInSingular('candidature')
            ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id', 'Id')
                ->onlyOnIndex(),
            AssociationField::new('jobOffer', "Offre d'emploi")
                ->setFormTypeOption('choice_label', 'id'),
            Field::new('jobOffer.recruiter.email', 'Recruteur')
                ->onlyOnIndex(),
            AssociationField::new('Candidate', 'Candidat')
                ->setFormTypeOption('choice_label', 'email'),
            BooleanField::new('isActivated' ,'Activé')
        ];
    }
    
}
