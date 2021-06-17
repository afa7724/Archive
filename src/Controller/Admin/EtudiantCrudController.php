<?php

namespace App\Controller\Admin;

use App\Entity\Etudiant;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class EtudiantCrudController extends AbstractCrudController
{

   
    public static function getEntityFqcn(): string
    {
        return Etudiant::class;
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
   
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            TextField::new('firstname'),
            TextField::new('lastname'),
            IntegerField::new('niveau'),
            BooleanField::new('isVerified')->onlyOnIndex(),
            TextField::new('password')->onlyOnForms()->setHelp('
            Votre mot de passe doit comporter au moins 8 caractères, 
            contenir au moins un chiffres, une lettre en masjucule et minuscule, 
            et peux contenir des symboles.')->setFormType(PasswordType::class),
            TextField::new('confirmepassword')->onlyOnForms()->setFormType(PasswordType::class),
            AssociationField::new('filiere')->onlyOnForms(),
            DateTimeField::new('createdAt')->onlyOnDetail(),
            DateTimeField::new('updatedAt')->onlyOnDetail(),
            
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions

            ->add(Crud::PAGE_INDEX, Action::DETAIL)

            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon("fa fa-user")->addCssClass('btn btn-success');
            })
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon("fa fa-edit")->addCssClass('btn btn-warning');
            })
            ->update(Crud::PAGE_INDEX, Action::DETAIL, function (Action $action) {
                return $action->setIcon("fa fa-eye")->addCssClass('btn btn-info');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->setIcon("fa fa-trash")->addCssClass('btn btn-outline-danger');
            });;
    }


}
