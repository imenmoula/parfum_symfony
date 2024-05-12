<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Parfum;
use App\Form\searchType;
use App\Entity\Category;
use src\Class\Search; // Add this use statement
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    private $entityManager;
    private $request;

    #[Route('/product', methods: 'GET', name: 'app_product')]
    public function __construct(EntityManagerInterface $entityManager, Request $request)
    {
        $this->entityManager = $entityManager;
        $this->request = $request;
    }

    #[Route('/product', methods: 'GET', name: 'app_product')]
    public function index(): Response
    {
        // $parfums = $this->entityManager->getRepository(Parfum::class)->findAll();
        $search = new search(); 
        $form = $this->createForm(searchType::class, $search);
        $form->handleRequest($this->request);

        if($form->isSubmitted() && $form->isValid()){
            $parfums = $this->entityManager->getRepository(Parfum::class)->findWithSearch($search);
        }
        else 
        {
            $parfums = $this->entityManager->getRepository(Parfum::class)->findAll();

        }

        return $this->render('product/index.html.twig', [
            'parfums' => $parfums,
            'form' => $form->createView(),
        ]);
    }
    #[Route('/products/{nom}', methods: ['GET'], name: 'product')]
    public function show($nom): Response
    {
        //dd($slug);
        $parfums = $this->entityManager->getRepository(Parfum::class)->findOneBy(['nom' => $nom]);
        //dd($parfums);
        if(!$parfums){
            return $this->redirectToRoute('app_product');
        }
        return $this->render('product/show.html.twig', [
        'parfums'=> $parfums         
        ]);
    }
}
