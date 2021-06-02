<?php

namespace App\Controller\Admin;

use App\Entity\Filiere;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class FiliereCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Filiere::class;
    }


    public function configureFields(string $pageName): iterable
    {


        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name'),
            DateTimeField::new('createdAt')->onlyOnDetail(),
            DateTimeField::new('updateAt')->onlyOnDetail(),
            CollectionField::new('archives')->onlyOnDetail(),
            CollectionField::new('professeurs')->onlyOnDetail(),
            CollectionField::new('etudiants')->onlyOnDetail()
        ];
    }
  
    // hideOnDetail()
    // hideOnForm()
    // hideOnIndex()
    // onlyOnDetail()
    // onlyOnForms()
    // onlyOnIndex()
    // onlyWhenCreating()
    // onlyWhenUpdating()
}
