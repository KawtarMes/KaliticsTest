<?php

namespace App\Form;

use App\Entity\Clocking;
use App\Entity\User;
use App\Repository\ProjectRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminClockingType extends AbstractType
{
    public function __construct(
        private ProjectRepository $projectRepository
    ){}//pour rappeler les chantier dans choicetype

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('clockingProjects', CollectionType::class, [
            'entry_type' => ClockingProjectType::class,
            'entry_options' => ['label' => false], 
            'allow_add' => true, 
            'allow_delete' => true, 
            'by_reference' => false, 
            'prototype' => true,
            'prototype_name' => '__name__',
        ])
        ->add('clockingUsers', CollectionType::class, [
            'entry_type' => EntityType::class,
            'entry_options' => [
                'label' => 'Collaborateurs',
                'class' => User::class,
                'choice_label' => 'username',
            ],
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false,
            'prototype' => true,
            'prototype_name' => '__name__user',
        ])
        ->add('save', SubmitType::class, ['label' => 'Enregistrer']);
}


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Clocking::class,
        ]);
    }
}
