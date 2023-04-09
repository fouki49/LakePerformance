<?php

namespace App\Controller;

use App\Entity\Constantes;
use App\Entity\Panier;
use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Core\Notification;
use App\Core\NotificationColor;

class PanierController extends AbstractController
{
    private $em = null;
    private $achatList;
    private $produit;
    private $panier;


    #[Route('/panier', name: 'app_panier')]
    public function index(Request $request): Response
    {
        $this->initSession($request);
        $session = $request->getSession();
        $fraisLivraison = Constantes::FRAIS_LIVRAISON;

        $this->panier = new Panier($this->achatList->getAchats());

        if ($this->achatList->getAchats() == null) {
            $this->addFlash(
                'panier',
                new Notification('success', 'No products in the basket', NotificationColor::WARNING)
            );
        }

        return $this->render('panier/panier.html.twig', [
            'name' => $session->get('name'),
            'achatlist' => $this->achatList,
            'fraislivraison' => empty($this->achatList->getAchats()) ? '0.00' : $fraisLivraison,
            'panier' => $this->panier,
        ]);
    }


    #[Route('/panier/ajout/{idProduit}', name: 'app_ajout_panier',  /*methods: ['POST']*/)]
    public function addAchat($idProduit, Request $request, ManagerRegistry $doctrine): Response
    {
        $this->initSession($request);
        $this->em = $doctrine->getManager();
        $produit = $this->em->getRepository(Produit::class)->find($idProduit);
        $validation = $this->achatList->validerExistanceDansPanier($idProduit);

        if ($validation) {
            $this->achatList->ajouterQuantitePanier($idProduit);
            $this->addFlash(
                'achat',
                new Notification('success', 'This product was already in the cart, the quantity and the price have been adjusted', NotificationColor::INFO)
            );
        } else {
            $this->achatList->ajouterAchat($produit);
            $this->addFlash(
                'achat',
                new Notification('success', 'The product has been successfully added to the basket', NotificationColor::SUCCESS)
            );
        }
        return $this->redirectToRoute('app_panier');
    }


    #[Route('/panier/supprimer/{idProduit}', name: 'app_delete_achat')]
    public function deleteAchat($idProduit, Request $request): Response
    {
        $this->initSession($request);

        $this->addFlash(
            'achat',
            new Notification('success', 'This product has been removed from the cart', NotificationColor::INFO)
        );
        $this->achatList->supprimerAchat($idProduit);
        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/update', name: 'app_update_achat', methods: ['POST'])]
    public function updateAchatPanier(Request $request): Response
    {
        $post = $request->request->all();
        $this->initSession($request);

        $action = $request->request->get('action');


        if ($action == "update") {

            $this->achatList->updateAchat($post);

            if ($this->achatList->getAchats() != null) {
                $this->addFlash(
                    'achat',
                    new Notification('success', 'The purchases in the cart have been updated', NotificationColor::INFO)
                );
            } else {
                $this->addFlash(
                    'achat',
                    new Notification('error', 'No modifiable product, the basket is empty', NotificationColor::DANGER)
                );
            }
        } else if ($action == "empty") {
            $session = $request->getSession();

            //* Valide si le panier est vide pour ne pas renvoyer la notification que le panier est vide
            if ($this->achatList->getAchats() != null) {
                $this->addFlash(
                    'achat',
                    new Notification('success', 'All products have been removed from the cart', NotificationColor::INFO)
                );
            }
            $session->remove('achatlist');
        }
        return $this->redirectToRoute('app_panier');
    }


    private function initSession(Request $request)
    {

        $session = $request->getSession();
        //TODO: eventuellement mettre le nom de l'utilisateur connecter
        $session->set('name', 'Benjamin');

        $this->achatList = $session->get('achatlist', new Panier());

        $session->set('achatlist', $this->achatList);
    }
}
