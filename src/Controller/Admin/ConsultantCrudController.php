<?php

namespace App\Controller\Admin;

use App\Entity\Consultant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ConsultantCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Consultant::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInPlural('Consultants')
            ->setEntityLabelInSingular('consultant')
            ;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
