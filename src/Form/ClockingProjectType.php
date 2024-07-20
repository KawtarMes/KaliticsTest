<?php

namespace App\Form;

use App\Entity\Clocking;
use App\Entity\ClockingProject;
use App\Entity\Project;
use App\Repository\ProjectRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClockingProjectType extends AbstractType
{
    // injection de dépendance
    public function __construct(
        private ProjectRepository $projectRepository
    ){ }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $projects = $this->projectRepository->findAll();// pouvoir recuperé  les obj projet pour les selectionner
        $builder
            ->add('project', ChoiceType::class, [
                'choices' => $projects,
                'choice_label' => function(Project $project) {
                    return $project->getName();
                },
                'choice_value' => function(Project $project = null) {
                    return $project ? $project->getId() : '';
                },
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
