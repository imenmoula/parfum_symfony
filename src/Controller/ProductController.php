<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Parfum;
use App\Form\searchType;
use App\Entity\Category;
use src\Search ;

class ProductController extends AbstractController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/product', methods: 'GET', name: 'app_product')]
    public function index(): Response
    {
        $parfums = $this->entityManager->getRepository(Parfum::class)->findAll();
        //dd($parfum);
        $form=$this->createForm(searchType::class,$search);
        $search = new search();

        return $this->render('product/index.html.twig', [
        'parfums'=> $parfums,
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
