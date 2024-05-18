<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Category;
use App\Entity\parfum;
use App\Repository\CategoryRepository;

class HomeController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    #[Route('/home', name: 'app_home')]
    public function index(SessionInterface $session,CategoryRepository $categoryRepository): Response
    {
       
    //    $session->remove('cart');
    //     $cart=$session->get('cart');

        //dd($cart);
        $categories=$categoryRepository->findAll();

        return $this->render('home/index.html.twig',[
            "categories"=>$categories,
            "controller_name" => "HomeController",
        ]
        );
    }
    
}
