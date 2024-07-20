<?php

namespace App\Controller;

use App\Entity\Clocking;
use App\Entity\ClockingProject;
use App\Form\ClockingProjectType;
use App\Form\ClockingType;
use App\Repository\ClockingProjectRepository;
use App\Repository\ClockingRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PointageController extends AbstractController
{
    #[Route('/clocking/new', name: 'clocking_new')]
    public function createClocking(EntityManagerInterface $entityManager, Request $request): Response
    {
        $clocking = new Clocking();
        // Setting des valeurs connues automatique (user connecté et date du jour)
        $clocking->setClockingUser($this->getUser());
        $clocking->setDate(new \DateTime('now'));

        $form = $this->createForm(ClockingType::class, $clocking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Associer chaque ClockingProject à son Clocking parent
            foreach ($clocking->getClockingProjects() as $clockingProject) {
                $clockingProject->setClocking($clocking);
                $entityManager->persist($clockingProject);
            }

            $entityManager->persist($clocking);
            $entityManager->flush();

            // Redirection vers la liste des pointages
            return $this->redirectToRoute('pointage_list');
        } else {
            dump($form->getErrors(true));
        }

        // Rendu du formulaire
        return $this->render('pointage/new_pointage.html.twig', [
            'form' => $form->createView(),
            'user' => $this->getUser()
        ]);
    }

    #[Route('/pointage/list', name: 'pointage_list')]
    public function success(ClockingProjectRepository $CPrepo): Response
    {
        // Récupérer tout les pointages pour les afficher
        $ClockingProjects = $CPrepo->findAll();
        // Rend la liste des pointages
        return $this->render('pointage/liste_pointages.html.twig', ['Pointages' => $ClockingProjects]);
    }

    
}


