<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product/{name}', methods: 'GET', name: 'app_product')]
    public function index($name): Response
    {
        return $this->render('product/index.html.twig', [
            #'controller_name' => 'ProductController',
            'name' => $name, 
        ]);
    }
}
