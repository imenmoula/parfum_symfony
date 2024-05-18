<?php

namespace App\Controller;

use App\Entity\Parfum;
use App\Entity\Category;
use App\Form\ParfumType;
use App\Repository\ParfumRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/parfum')]
class ParfumController extends AbstractController
{
    private $targetDirectory;

    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $params)
    {
        $this->entityManager = $entityManager;
        $this->targetDirectory = $params->get('parfum_uploads_directory');
    }
    
    #[Route('/', name: 'app_parfum_index', methods: ['GET'])]
    public function index(ParfumRepository $parfumRepository): Response
    {
        return $this->render('parfum/index.html.twig', [
            'parfums' => $parfumRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_parfum_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $parfum = new Parfum();
        $form = $this->createForm(ParfumType::class, $parfum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($parfum);
            $uploadedFile = $form->get('image')->getData();
                if ($uploadedFile) {
                    $newFileName = md5(uniqid()) . '.' . $uploadedFile->guessExtension();
                    $uploadedFile->move($this->targetDirectory, $newFileName);
                    $parfum->setImage($newFileName);
                }
            $entityManager->flush();

            return $this->redirectToRoute('app_parfum_index', [], Response::HTTP_SEE_OTHER);
        }
            

        return $this->render('parfum/new.html.twig', [
            'parfum' => $parfum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parfum_show', methods: ['GET'])]
    public function show(Parfum $parfum): Response
    {
        return $this->render('parfum/show.html.twig', [
            'parfum' => $parfum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_parfum_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parfum $parfum, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ParfumType::class, $parfum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            return $this->redirectToRoute('app_parfum_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('parfum/edit.html.twig', [
            'parfum' => $parfum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_parfum_delete', methods: ['POST'])]
    public function delete(Request $request, Parfum $parfum, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parfum->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($parfum);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_parfum_index', [], Response::HTTP_SEE_OTHER);
    }

    
}
