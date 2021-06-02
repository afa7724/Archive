<?php

namespace App\Controller\Admin;

use App\Entity\Archive;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
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
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Vich\UploaderBundle\Form\Type\VichImageType;

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
            NumberField::new('Niveau'),
            DateField::new('datepromotionOn')->hideOnIndex(),
            TextField::new('Encadreur'),
            TextEditorField::new('description')->hideOnIndex(),
            DateTimeField::new('createdAt')->hideOnForm(),
            DateTimeField::new('updatedAt')->hideOnForm(),
            AssociationField::new('user')->onlyOnDetail(),
            // VichImageField::new('imageFile')->onlyOnForms()->setFormType(VichImageType::class),
            // ImageField::new('filecodesources')->onlyOnForms()->setFormType(VichImageType::class),
            $imageFile = ImageField::new('rapportfilename')
                ->setBasePath('public/uploads/brochures') // Needed for Index page
                ->setUploadDir('public/uploads/brochures')
                ->setHelp("Fichier PDF"), //Needed for new / edit page
            $filecodesources = ImageField::new('codesource')
                ->setBasePath('public/uploads/brochures/codesources')
                ->setUploadDir('public/uploads/brochures/codesources')
                ->setHelp("Fichier RAR") //Needed for new / edit page

        ];
    }
   

    public function createEntity(string $entityFqcn)
    {

        $archive = new Archive();
        $archive->setUser($this->getUser());

        return $archive;
    }

   
}
