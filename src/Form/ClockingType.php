<?php

namespace App\Form;

use App\Entity\Clocking;
use App\Entity\Project;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClockingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('date', DateType::class, [
            'widget' => 'single_text',
            'label' => 'Date',
        ])
        ->add('clockingUser', EntityType::class, [
            'class' => 'App\Entity\User',
            'choice_label' => 'firstName',
            'label' => 'Utilisateur',
        ])
        ->add('clockingProjects', CollectionType::class, [
            'entry_type' => ClockingProjectType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'label' => 'Projets',
            'entry_options' => ['label' => false],
        ])
        ->add('save', SubmitType::class, ['label' => 'Enregistrer']);
   
        
            // ->add('date')
            // ->add('duration')
            // ->add('clockingProject', EntityType::class, [
            //     'class' => Project::class,
            //     'choice_label' => 'id',
            // ])
            // ->add('clockingUser', EntityType::class, [
            //     'class' => User::class,
            //     'choice_label' => 'id',
            // ])
            ;
              
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Clocking::class,
        
        ]);
    }
}
