<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use App\Repository\UserRepository; 

class SecurityController extends AbstractController
{


    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

   
    #[Route('/connexion', name: 'connexion', methods: ['GET', 'POST'])]
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {
        // If user is already authenticated, redirect to home page
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
    
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
    
        // last email entered by the user
        $lastEmail = $authenticationUtils->getLastUsername();
    
        // Retrieve submitted credentials from the request
        $email = $request->request->get('email');
        $password = $request->request->get('password');
    
        // Check if email is null
        if ($email === null) {
            // Handle the case where email is null (e.g., redirect back to login page with an error message)
            return $this->render('security/login.html.twig', [
                'last_email' => $lastEmail,
                'error' => $error,
                'error_message' => 'Email cannot be empty.',
            ]);
        }
    
        // You can perform any necessary validation or verification here
        // For example, you might want to authenticate the user using Symfony's security system
        // Assuming you have a UserRepository and an appropriate method for finding user by email
    
        // Handle authentication
        try {
            $user = $this->userRepository->findOneByEmail($email);
            
            if (!$user || !$this->passwordEncoder->isPasswordValid($user, $password)) {
                throw new BadCredentialsException('The email or password is incorrect.');
            }
    
            // Authentication successful, handle redirection or other logic
        } catch (BadCredentialsException $e) {
            // Authentication failed, handle error (e.g., redirect back to login page with error message)
            return $this->render('security/login.html.twig', [
                'last_email' => $lastEmail,
                'error' => $error,
                'error_message' => $e->getMessage(),
            ]);
        }
    }

    #[Route('/logout', name: 'logout', methods: ['GET', 'POST'])]

    public function logout()
    {
        throw new \Exception('This should never be reached!');
    }

   
}
