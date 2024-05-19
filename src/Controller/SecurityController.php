<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Security;
class SecurityController extends AbstractController
{

   
    #[Route('/connexion', name: 'connexion', methods: ['GET', 'POST'])]

    public function login(Request $request, AuthenticationUtils $authenticationUtils , Security $security)
    {

      
        // If user is already authenticated, redirect to home page
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();



    // Now you can perform any validation or verification with the $email and $password

    // Example: Dumping email and password for verification
    dump($email, $password);

        return $this->render('security/login.html.twig', [
            'last_email' => $lastEmail,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'logout', methods: ['GET', 'POST'])]

    public function logout()
    {
        throw new \Exception('This should never be reached!');
    }
}
