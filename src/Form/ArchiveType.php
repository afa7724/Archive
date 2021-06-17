<?php

namespace App\Form;

use App\Entity\Archive;
use App\Entity\Filiere;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ArchiveType extends AbstractType
{
    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }
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
            ->add('Niveau', IntegerType::class, [
                'label' => 'Niveau universitaire',

            ])
            ->add('datepromotionOn', null, [
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
                'label' => 'Fichier rattacher (Fichier PDF)',
                'attr' => ['placeholder' => 'Veuillez selectionne un fichier PDF'],
                // unmapped means that this field is not associated to any entity property
                // 'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '3M',
                        'mimeTypes' => [
                            'application/pdf',
                            'application/x-pdf',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un document PDF valide',
                    ])
                ],
            ])
            ->add('filecodesources', FileType::class, [
                'label' => 'Fichier de code sources (Fichier RAR)',
                'attr' => ['placeholder' => 'Veuillez selectionne un fichier rar'],
                // unmapped means that this field is not associated to any entity property
                // 'mapped' => false,

                // make it optional so you don't have to re-upload the PDF file
                // every time you edit the Product details
                'required' => false,

                // unmapped fields can't define their validation using annotations
                // in the associated entity, so you can use the PHP constraint classes
                'constraints' => [
                    new File([
                        'maxSize' => '4M',
                        'mimeTypes' => [
                            'application/rar',
                            'application/x-rar',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger un document rar valide',
                    ])
                ],
            ])

            ->add(
                'filiere',
                EntityType::class,
                [
                    'class' => Filiere::class,
                    'choice_label' => 'name',
                    'label' => 'Filière',
                    //Select filiere name by current user 
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('f')
                            ->innerJoin('f.professeurs', 'p', 'WITH', 'p.id = :val')
                            ->setParameter('val', $this->token->getToken()->getUser())
                            ->orderBy('f.name', 'ASC');
                    },
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
