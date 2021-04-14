<?php

namespace App\Form;

use App\Entity\Archive;
use App\Entity\Filiere;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ArchiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => ['placehorlder' => 'Le nom de l\'archive']
            ])
            ->add('description', null, [
                'label' => 'Description',

            ])
            ->add('Encadreur', TextType::class, [
                'label' => 'Encadreur',

            ])
            ->add('datepromotionOn',null,[
                'label' => 'Date de Promo'
                // 'widget' => 'single_text',
                // 'input' => 'string',
                // 'format' => 'yyyy-MM-dd'
            ])
            ->add(
                'type',
                ChoiceType::class,
                [
                    'choices'  => Archive::TYPE,
                    'label' => 'Type d\'archive'
                ]
            )
            ->add('imageFile', FileType::class, [
                'label' => 'Rapport du projet (Fichier PDF)',
                 'attr' => ['placeholder'=> 'Veuillez selectionne un fichier PDF'],   
                // unmapped means that this field is not associated to any entity property
                // 'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un document PDF valide',
                    ])
                ],
            ])
            ->add(
                'filiere',
                EntityType::class,
                [
                    'class' => Filiere::class,
                    'choice_label' => 'name',
                    'label' => 'Filière'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Archive::class,
        ]);
    }
}
