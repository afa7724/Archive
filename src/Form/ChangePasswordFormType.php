<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($options['current_password_is_required']) {
            $builder
                ->add('currentPassword', PasswordType::class, [
                    'label' => 'Mot de passe actuel',
                    'attr' => [
                        'autocomplete' => 'off'
                    ],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez saisir votre mot de passe actuel.',
                        ]),
                        new UserPassword(['message' => 'Mot de passe actuel non valide.']),
                    ]
                ]);
        }
       
        $builder
            ->add('newPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer un mot de passe',
                        ]),
                        new Length([
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                        new Regex([
                            'pattern' => "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$/",
                            'htmlPattern' => "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$",
                            'match' => 'true',
                            'message' => "Respectez le message d'aide ci-dessous"
                        ]),
                    ],
                    'label' => 'Nouveau mot de passe',
                    'help' => 'Votre mot de passe doit comporter au moins 8 caractères, 
                    contenir au moins un chiffres, une lettre en masjucule et minuscule, 
                    et peux contenir des symboles.',
                ],
                'second_options' => [
                    'label' => 'Répéter le mot de passe',
                ],
                'invalid_message' => 'Les champs du mot de passe doivent correspondre.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,

            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'current_password_is_required' => false
        ]);

        $resolver->setAllowedTypes('current_password_is_required', 'bool');
    }
}
