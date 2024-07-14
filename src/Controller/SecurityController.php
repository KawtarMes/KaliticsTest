<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;


#[Route('/security')]
class SecurityController extends AbstractController
{
    // #[Route('/', name: 'app_security')]
    // public function index(): Response
    // {
    //     return $this->render('security/index.html.twig', [
    //         'controller_name' => 'SecurityController',
    //     ]);
    // }

    //inscription : création d'un user
    #[Route('/signup', name: 'sign_up')]
    public function signup(EntityManagerInterface $manager, Request $request, UserPasswordHasherInterface $hasher)
    {
        //créer une instance de User
        $user = new User;
        //créer le form avec le RegistrationType 
        $form = $this->createForm(RegistrationType::class);
        //gerer la requete
        $form->handleRequest(($request));
        //verifier le form  
        if ($form->isSubmitted() && $form->isValid()) {
            //hydrater l'obj User avec les saisies recuperées
            $user = $form->getData();
            //hasher le mot de passe
            $user->setPassword($hasher->hashPassword($user, $form->get('password')->getData()));

            //set active a 0 jusqua verification
            $user->setActive(0);
        }

        //generer un token
        $token = $this->generateToken();
        //attribuer le token
        $user->setToken($token);
        //prepare and execute
        $manager->persist($user);
        $manager->flush();
        //message flash

        //mail de validation
        //redirection à la page de connexion


        return $this->render('/security/signup.html.twig', ['form' => $form->createView()]);
    }

    //Fonction pour générer des Tokens
    private function generateToken()
    {
        // rtrim supprime les espaces en fin de chaine de caractère
        // strtr remplace des occurences dans une chaine ici +/ et -_ (caractères récurent dans l'encodage en base64) par des = pour générer des url valides
        // ce token sera utilisé dans les envoie de mail pour l'activation du compte ou la récupération de mot de passe
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
}
