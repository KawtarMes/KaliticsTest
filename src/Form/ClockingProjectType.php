<?php

namespace App\Form;

use App\Entity\Clocking;
use App\Entity\ClockingProject;
use App\Entity\Project;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClockingProjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // ->add('duration',IntegerType::class ,['label'=>'Durée'])
            // ->add('clocking', EntityType::class, [
            //     'class' => Clocking::class,
            //     'choice_label' => 'ClockingId',
            // ])
            // ->add('project', EntityType::class, [
            //     'class' => Project::class,
            //     'choice_label' => 'Chantier',
            // ]);
            ->add('project', EntityType::class, [
                'class' => 'App\Entity\Project',
                'choice_label' => 'name', // assuming 'name' is the property you want to display
                'label' => 'Chantier',
            ])
            ->add('duration', IntegerType::class, [
                'label' => 'Durée',
            ]);

        }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClockingProject::class,
        ]);
    }
}
