<?php

namespace App\Controller\Admin;

use App\Entity\Archive;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArchiveCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Archive::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('title'),
            ChoiceField::new('type')->setChoices([
                'Mini Projet' => 'Mini Projet',
                'Rapport de stage' => 'Rapport de stage',
                'Projet Tutoriel' => 'Projet Tutoriel',
                'Memoire' => 'Memoire',
            ]),
            AssociationField::new('filiere')->autocomplete(),
            NumberField::new('Niveau')->setFormType(IntegerType::class),
            DateField::new('datepromotionOn')->hideOnIndex(),
            TextField::new('Encadreur')->hideOnIndex(),
            TextEditorField::new('description')->hideOnIndex(),
            DateTimeField::new('createdAt')->onlyOnDetail(),
            DateTimeField::new('updatedAt')->onlyOnDetail(),
            AssociationField::new('user')->hideOnindex(),
            // VichImageField::new('imageFile')->onlyOnForms()->setFormType(VichImageType::class),
            // ImageField::new('filecodesources')->onlyOnForms()->setFormType(VichImageType::class),
            $imageFile = ImageField::new('rapportfilename')
                ->setBasePath('public/uploads/brochures') // Needed for Index page
                ->setUploadDir('public/uploads/brochures')
                ->setHelp("Fichier PDF")
                ->onlyOnForms(), //Needed for new / edit page
            $filecodesources = ImageField::new('codesource')
                ->setBasePath('public/uploads/brochures/codesources')
                ->setUploadDir('public/uploads/brochures/codesources')
                ->setHelp("Fichier RAR")
                ->onlyOnForms(), //Needed for new / edit page

        ];
    }


    public function createEntity(string $entityFqcn)
    {

        $archive = new Archive();
        $archive->setUser($this->getUser());

        return $archive;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions

            ->add(Crud::PAGE_INDEX, Action::DETAIL)

            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon("fa fa-list")->addCssClass('btn btn-success');
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
