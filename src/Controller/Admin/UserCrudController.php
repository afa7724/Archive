<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            TextField::new('firstname'),
            TextField::new('lastname'),
            TextField::new('password')->onlyOnForms(),
            
        ];
    }
    
    public function configureActions(Actions $actions): Actions
    {
    return $actions
    
        ->add(Crud::PAGE_INDEX, Action::DETAIL)

        ->update(Crud::PAGE_INDEX, Action::NEW,function(Action $action){
            return $action->setIcon("fa fa-user")->addCssClass('btn btn-success');
        })
        ->update(Crud::PAGE_INDEX, Action::EDIT,function(Action $action){
            return $action->setIcon("fa fa-edit")->addCssClass('btn btn-warning');
        })
        ->update(Crud::PAGE_INDEX, Action::DETAIL,function(Action $action){
            return $action->setIcon("fa fa-eye")->addCssClass('btn btn-info');
        })
        ->update(Crud::PAGE_INDEX, Action::DELETE,function(Action $action){
            return $action->setIcon("fa fa-trash")->addCssClass('btn btn-outline-danger');
        });
    ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add('lastname');
    }

    public function configureCrud(Crud $crud): Crud
{
    return $crud
        // the names of the Doctrine entity properties where the search is made on
        // (by default it looks for in all properties)
        ->setSearchFields(['email']);
}
}
