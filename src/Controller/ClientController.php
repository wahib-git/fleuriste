<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\PanierType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/client')]
class ClientController extends AbstractController
{
    #[Route(name: 'app_produit_index_client', methods: ['GET'])]
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('client/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }


    #[Route('/{id}', name: 'app_produit_show_client')]
    public function show(Produit $produit, Request $request): Response
    {
        // Create the form
        $form = $this->createForm(PanierType::class);
        // Handle the request
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get the quantity from the form
            $data = $form->getData();

            // Redirect or process the order
            return $this->redirectToRoute('passerCommande', [
                'id' => $produit->getId(),
                'quantite' => $data->getQuantite(),
            ]);
        }

        return $this->render('client/show.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

}