<?php

namespace App\Controller;

use App\Entity\Ressources;
use App\Form\RessourcesType;
use App\Repository\RessourcesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/ressources')]
final class RessourcesController extends AbstractController
{
    #[Route(name: 'app_ressources_index', methods: ['GET'])]
    public function index(RessourcesRepository $ressourcesRepository): Response
    {
        return $this->render('ressources/index.html.twig', [
            'ressources' => $ressourcesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_ressources_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
      $ressource = new Ressources();

        $form = $this->createForm(RessourcesType::class, $ressource);

        $form->handleRequest($request);


          if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($ressource);
            $entityManager->flush();

            return $this->redirectToRoute('app_ressources_index', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('ressources/indexx.html.twig', [
            'ressource' => $ressource,
            'form' => $form->createView(),
        ]);



    }

    #[Route('/{id}', name: 'app_ressources_show', methods: ['GET'])]
    public function show(Ressources $ressource): Response
    {
        return $this->render('ressources/show.html.twig', [
            'ressource' => [
        'id' => $ressource->getId(),
        'type' => $ressource->getType()->name,
        'quantiteDisponible' => $ressource->getQuantiteDisponible(),
        'dateAjout' => $ressource->getDateAjout(),
    ],

            ]);
    }

    #[Route('/{id}/edit', name: 'app_ressources_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Ressources $ressource, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RessourcesType::class, $ressource);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_ressources_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('ressources/edit.html.twig', [
            'ressource' => $ressource,
            'form' => $form->createView(),
        ]);
    }

  /*  #[Route('/ressources/{id}/delete', name: 'app_ressources_delete', methods: ['POST'])]
    public function delete(Request $request, Ressources $ressource, EntityManagerInterface $entityManager): Response
    {
        // Vérification CSRF
        if ($this->isCsrfTokenValid('delete'.$ressource->getId(), $request->getPayload()->getString('_token'))) {

            $entityManager->remove($ressource);
            $entityManager->flush();

            $this->addFlash('success', 'Ressource supprimée avec succès.');
        } else {
            $this->addFlash('error', 'Jeton CSRF invalide. Suppression annulée.');
        }

  
        return $this->redirectToRoute('app_ressources_index');
    }*/



    #[Route('/ressources/delete/{id}', name: 'ressources_delete', methods: ['POST'])]
    public function delete(Ressources $ressource, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($ressource);

        $entityManager->flush();

        return $this->redirectToRoute('app_ressources_index');
    }
    


    
}
