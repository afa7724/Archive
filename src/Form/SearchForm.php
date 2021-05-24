<?php

namespace App\Form;

use App\Data\SearchData;
use App\Entity\Filiere;
use App\Entity\Archive;
use App\Entity\DechetRecherche;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchForm extends AbstractType{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('q',TextType::class,[
                'label'=> false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Rechercher'
                ]
            ])
            
            ->add('filiere',EntityType::class,[
                'required' => false,
                'label' => false,
                'class' => Filiere::class,
                'expanded' => true
                
                
            ])
            
            // ->add('min',NumberType::class,[
            //     'required' => false,
            //     'label' =>false,
            //     'attr' => [
            //         'placeholder' => 'Prix minumum '
            //     ]
            // ])
            ->add('typearchive',ChoiceType::class,[
                'required' => false,
                'label' =>false,
                'expanded' => true,
                'choices' =>$this->getChoicesOrigine()
            ])
            // ->add('promo',CheckboxType::class,[
            //     'label' => 'En promotion',
            //     'required' => false,
            // ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchData::class,
            'method' => 'GET',
            'csrf_protection' => false

        ]);
    }
    public function getBlockPrefix()
    {
        return '';
    }
    public function getChoicesOrigine()
    {
        $choices = Archive::TYPE;
        $output = [];
        foreach ($choices as $k => $v)
        {
            $output[$v] =$k;
        }
        return $output;

    }
    

}