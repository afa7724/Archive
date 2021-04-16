<?php

namespace App\Form;

use App\Entity\Filiere;
use App\Entity\Etudiant;
use App\Form\RegistrationFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class EtudiantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('foo', RegistrationFormType::class, [
                'data_class' => Etudiant::class,
                'label' => false
            ])
            ->add('niveau',IntegerType::class,[
                'label'=> 'Niveau universitaire',
                
            ])
            ->add('filiere',EntityType::class,
            [
                'class' => Filiere::class,
                'choice_label' => 'name',
                'label' => 'Filière',
                
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Etudiant::class,
        ]);
    }
}
