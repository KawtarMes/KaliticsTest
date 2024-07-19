<?php

namespace App\Controller;

use App\Entity\Clocking;
use App\Entity\ClockingProject;
use App\Form\ClockingProjectType;
use App\Form\ClockingType;
use App\Repository\ClockingProjectRepository;
use App\Repository\ClockingRepository;
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

    // Ajouter des ClockingProject à l'entité Clocking
    for ($i = 0; $i < 3; $i++) {
        $clockingProject = new ClockingProject();
        $clocking->addClockingProject($clockingProject);
    }

    $form = $this->createForm(ClockingType::class, $clocking);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // La relation bidirectionnelle doit être correctement configurée
        foreach ($clocking->getClockingProjects() as $clockingProject) {
            $clockingProject->setClocking($clocking);
        }

        // Persist l'entité Clocking (et ses ClockingProjects si cascade est configuré)
        $entityManager->persist($clocking);
        $entityManager->flush();

        // Redirection vers la liste des pointages
        return $this->redirectToRoute('pointage_list');
    }

    // Rendu du formulaire
    return $this->render('pointage/new_pointage.html.twig', [
        'form' => $form->createView(),
    ]);
    }

  


//    // Route pour créer un nouveau pointage
//    #[Route('/clocking/new', name: 'clocking_new')]
//    public function new(Request $request, EntityManagerInterface $entityManager): Response
//    {
//        // nouvelle instance de Clocking
//        $clocking = new Clocking();
       
//        // Création du form 
//        $form = $this->createForm(ClockingType::class, $clocking);

//        // Traitement de la requête HTTP
//        $form->handleRequest($request);

//        // Vérification si le formulaire est soumis et valide
//        if ($form->isSubmitted() && $form->isValid()) {
//            // Persist l'entité Clocking principale
//            $entityManager->persist($clocking);

//            // Persist chaque entité ClockingProject associée
//            foreach ($clocking->getClockingProjects() as $clockingProject) {
//                // Associe l'entité Clocking à l'entité ClockingProject
//                $clockingProject->setClocking($clocking);
//                // Persist l'entité ClockingProject
//                $entityManager->persist($clockingProject);
//            }

//            // Sauvegarde toutes les entités dans la base de données
//            $entityManager->flush();

//            // Redirection vers liste de pointages
//            return $this->redirectToRoute('pointage_list');
//        }

//        // Rendu du template avec le formulaire de création de pointage
//        return $this->render('pointage/new_pointage.html.twig', [
//            'form' => $form->createView(),
//        ]);
//    }


    #[Route('/pointage/list', name: 'pointage_list')]
    public function success(ClockingProjectRepository $CPrepo): Response
    {
        //recuperer tout les pointages pour les afficher
        $ClockingProjects = $CPrepo->findAll();
        // Rend la liste des pointages
        return $this->render('pointage/liste_pointages.html.twig',['Pointages'=>$ClockingProjects]);
    }
}
