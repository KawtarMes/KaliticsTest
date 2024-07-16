<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class SecurityController extends AbstractController
{

    //inscription , création d'user
    #[Route('/signup', name: 'sign_up')]
    public function signup(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher, MailerInterface $mailer): Response
    {
        //nouvelle instance de user
        $user = new User();
        //creation du form à l'aide du registration type
        $form = $this->createForm(RegistrationType::class, $user);
        //gerer le form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //hachage de mot de passe
            $hashedPassword = $passwordHasher->hashPassword($user, $user->getPassword());
            $user->setPassword($hashedPassword);

            //par default le user il est pas active et role user
            $user->setActive(0);
            $user->setRoles(['ROLE_USER']);

            //generer le token 
            $token = $this->generateToken();
            $user->setToken($token);

            //prepare and execute en bdd
            $entityManager->persist($user);
            $entityManager->flush();

            //envoyer le mail de validation 
            $this->sendConfirmationEmail($user, $mailer);

            //message  flash
            $this->addFlash('success', 'Vous venez de vous inscrire! Verifiez votre email pour confirmer l\'inscription.');
            //redirection à la page de connexion
            return $this->redirectToRoute('login');
        }
        return $this->render('security/signup.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    //email de validation
    private function sendConfirmationEmail(User $user, MailerInterface $mailer)
    {
        // $email = (new TemplatedEmail())
        //     ->from(new Address('kawtarthebest@gmail.com'))
        //     ->to($user->getEmail())
        //     ->subject('Validez votre compte')
        //     ->htmlTemplate('emails/confirmation.html.twig')
        //     ->context([
        //         'user' => $user,
        //         'token' => $user->getToken(),
        //     ]);

        // $mailer->send($email);
    }

    private function generateToken()
    {
        return rtrim(strtr(base64_encode(random_bytes(32)), '+/', '-_'), '=');
    }
    //confirmer via le token
    #[Route('/confirm/{token}', name: 'confirm_email')]
    public function confirmEmail($token, EntityManagerInterface $entityManager): Response
    {
        //recuperer le user avec le token correspondant
        $user = $entityManager->getRepository(User::class)->findOneBy(['token' => $token]);
        // si on le trouve
        if ($user) {
            //on active et reset le token a null
            $user->setActive(1);
            $user->setToken(null);
            $entityManager->flush();

            $this->addFlash('success', 'Votre compte a bien été crée, connectez vous');
            //redirection pour se connecter
            return $this->redirectToRoute('login');
        }
        //sinon erreur et renvoyer pour tenter a nouveau l'inscription
        $this->addFlash('error', 'Invalid token.');
        return $this->redirectToRoute('sign_up');
    }
    //Connection Login
    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout(): void
    {
        // controller can be blank: it will never be executed!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
