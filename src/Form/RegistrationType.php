<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
     
            ->add('firstName', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                 
                ],
            ])
            ->add('lastName',TextType::class, [
                'constraints' => [
                    new NotBlank(),
                 
                ],
            ])
            ->add('matricule',TextType::class, [
                'constraints' => [
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9]+$/',
                        'message' => 'Le champ ne peut contenir que des lettres et des chiffres.',
                    ])
                ],
            ])
            ->add('email', EmailType::class)
            ->add('password',  RepeatedType::class, [
                'type'=> PasswordType::class,
                'required'=> true,
                'first_options'=> ['label'=> 'Mot de passe'],
                'second_options'=> ['label'=> 'Confirmation du mot de passe'],
                'invalid_message'=> 'Les mots de passe doivent correspondre',
                'constraints'=> [new Length([
                    'min'=> 6,
                    'minMessage' => 'Pas moins de {{ limit }} caratères',
                    'max' => 20,
                    'maxMessage' => 'Votre Mot de passe doit contenir maximum {{ limit }} caractères',
                ])]])
            ->add('Enregistrer', SubmitType::class)
      
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
