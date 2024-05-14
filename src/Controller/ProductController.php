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
use Symfony\Component\HttpFoundation\RequestStack;

class ProductController extends AbstractController
{
    private $entityManager;
    private $requestStack;

    #[Route('/product', methods: 'GET', name: 'app_product')]
    public function __construct(EntityManagerInterface $entityManager, RequestStack $requestStack)
    {
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    #[Route('/product', methods: 'GET', name: 'app_product')]
    public function index(): Response
    {
        $request = $this->requestStack->getCurrentRequest();

        // $parfums = $this->entityManager->getRepository(Parfum::class)->findAll();
        $search = new search(); 
        $form = $this->createForm(searchType::class, $search);
        $form->handleRequest($request);
        $criteria = ['nom' => $request->query->get('string')];
        if( $request->query->get('string')){
            $parfums = $this->entityManager->getRepository(Parfum::class)->findByNom($criteria);
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
