<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Filiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'help'=>'Un message de confirmation sera envoyé à cette adresse',
                'label' => 'Email',
                'attr' => ['placeholder' => 'example@example.com']
                 ])
            ->add('agreeTerms', CheckboxType::class, [
                'label'=>'Accepter les onditions d\'utilisation et la politique de confidentialité',
                'help'=>'Lire les Conditions d\'utilisation et la Politique de confidentialité',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions.',
                    ]),
                ],
            ])
            ->add('password', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                
                'help'=>'Votre mot de passe doit comporter au moins 8 caractères, 
                contenir au moins un chiffres, une lettre en masjucule et minuscule, 
                et peux contenir des symboles.',
                'label' => 'Mots de passe (Lettre et chiffre avec symbole)',
            ])
            ->add('firstname',TextType::class, [
                'label' => 'Prenom'
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom de famille'
            ])
            ->add('confirmepassword', PasswordType::class, 
                [ 'help'=>'Retapez votre mot de passe','label' => 'Confirmer le mot de passe ' ])
            
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
            'data_class' => User::class,
            'inherit_data' => true,
        ]);
    }
}
