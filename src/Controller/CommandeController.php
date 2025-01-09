<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\LigneDeCommande;
use App\Form\CommandeType;
use App\Form\PanierType;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
#[Route('/commande')]
final class CommandeController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private ProduitRepository $produitRepository;
    private CommandeRepository $commandeRepository;

    public function __construct(EntityManagerInterface $entityManager,
                                ProduitRepository $produitRepository,
                                CommandeRepository $commandeRepository)
    {
        $this->entityManager = $entityManager;
        $this->produitRepository = $produitRepository;
        $this->commandeRepository = $commandeRepository;
    }

    #[Route(name: 'app_commande_index', methods: ['GET'])]
    public function index(CommandeRepository $commandeRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }

    #[Route('/{id}', name: 'app_commande_show', methods: ['GET'])]
    public function show(int $id): Response
    {
        $commande = $this->commandeRepository->find($id);
        // Récupérer les lignes de commande associées
        $lignesDeCommande = $commande->getLigneDeCommandes();

        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
            'lignesDeCommande' => $lignesDeCommande,
        ]);
    }
    #[Route('/{id}', name: 'app_commande_delete', methods: ['POST'])]
    public function delete(Request $request): Response
    {
        $id = (int) $request->get('id');
        $commande = $this->commandeRepository->findOneBy(['id' => $id]);

        if (!$commande) {
            throw $this->createNotFoundException('Commande non trouvée.');
        }

        // Vérifier la validité du token CSRF
        $csrfToken = $request->get('_token');
        if ($this->isCsrfTokenValid('delete' . $commande->getId(), $csrfToken)) {
            // Supprimer les lignes associées dans ligne_de_commande
            foreach ($commande->getLigneDeCommandes() as $ligne) {
                $this->entityManager->remove($ligne);
            }

            // Supprimer la commande
            $this->entityManager->remove($commande);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_commande_index', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/passerCommande/{id}', name: 'passerCommande')]
    public function passerCommande(
        Request $request
    ): Response
    {
        $produitId = (int)$request->get('id');
        $quantite = (int)$request->get('quantite');

        $produit = $this->produitRepository->findOneBy(['id'=>$produitId]);

        $commande = new Commande();
        $commande->setDate(new \DateTime());
        $commande->setUser($this->getUser());
        $commande->setStatus("En attente de validation");
        $commande->setPrixTotal($produit->getPrix() * $quantite ?? 0);

        $ligneDeCommande = new LigneDeCommande();
        $ligneDeCommande->setProduit($produit);
        $ligneDeCommande->setQuantite($quantite);
        $ligneDeCommande->setCommande($commande);


        $this->entityManager->persist($commande);
        $this->entityManager->persist($ligneDeCommande);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_commande_show', ['id' => $commande->getId()]);
    }

}
