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
    private $total;
    private $tps;
    private $tvq;
    private $sommeTotal;


    #[Route('/panier', name: 'app_panier')]
    public function index(Request $request): Response
    {
        $this->initSession($request);
        $session = $request->getSession();
        $fraisLivraison = Constantes::FRAIS_LIVRAISON;
        $this->retrieveAllAchatListPrices();
        $this->calculTPS($this->total);
        $this->calculTVQ($this->total);
        $this->calculSommeTotal();

        if ($this->achatList->getAchats() == null) {
            $this->addFlash(
                'panier',
                new Notification('success', 'No products in the basket', NotificationColor::WARNING)
            );
        }

        return $this->render('panier/panier.html.twig', [
            'name' => $session->get('name'),
            'achatlist' => $this->achatList,
            'fraislivraison' => $fraisLivraison,
            'total' => $this->total,
            'tps' => $this->tps,
            'tvq' => $this->tvq,
            'sommetotal' => $this->sommeTotal,
        ]);
    }

    // #[Route('/panier/navbar', name: 'app_navbar')]
    // public function navbarRender(Request $request): Response
    // {
    //     $session = $request->getSession();
    //     return $this->render('core/navbar.html.twig', [
    //         'achatlist' => $this->achatList,
    //     ]);
    // }

    #[Route('/panier/ajout/{idProduit}', name: 'app_ajout_panier',  /*methods: ['POST']*/)]
    public function addAchat($idProduit, Request $request, ManagerRegistry $doctrine): Response
    {
        $this->initSession($request);
        // $post = $request->request->all();

        $this->em = $doctrine->getManager();

        $produit = $this->em->getRepository(Produit::class)->find($idProduit);

        if ($this->achatList->getAchats() == null) {
            $this->achatList->ajouterAchat(Constantes::QUANTITE, $produit->getPrix(), $produit);
            $this->addFlash(
                'achat',
                new Notification('success', 'The product has been successfully added to the basket', NotificationColor::SUCCESS)
            );
        }

        foreach ($this->achatList->getAchats() as $achat) {

            // echo "id produit ";
            // echo $idProduit;
            // echo "  id achat ";
            // echo $achat->getProduit()->getIdProduit();
            // die();

            // echo "nom produit ";
            // echo $produit->getNom();
            // echo "  nom achat ";
            // echo $achat->getProduit()->getNom();
            // die();

            // foreach ($achat as $idProdAchat) {
            //     echo $idProdAchat->getProduit()->getIdProduit();
            // }
            // die();

            if ($idProduit == $achat->getProduit()->getIdProduit()) {
                //TODO: incrementation de la quantite du produit

                //TODO: afficher une notification


            } else {
                $this->achatList->ajouterAchat(Constantes::QUANTITE, $produit->getPrix(), $produit);
                $this->addFlash(
                    'achat',
                    new Notification('success', 'The product has been successfully added to the basket', NotificationColor::SUCCESS)
                );
            }
            return $this->redirectToRoute('app_panier');
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
            //TODO Make it worrk
            $this->achatList->updateAchat($post);
            // foreach ($this->achatList->getAchats() as $achat) {
            //     if ($achat->getQuantite() == 0) {
            //         $this->achatList->supprimerAchat($achat->getProduit()->getIdProduit());
            //     }
            // }
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

    //permet d'avoir acces a un produit
    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function retrieveAllAchatListPrices()
    {
        foreach ($this->achatList->getAchats() as $achat) {
            $prix = $achat->getPrixAchat();
            $this->total += $prix;
        }
        return $this->redirectToRoute('app_panier');
    }

    public function calculTPS($total)
    {
        $this->tps = round($total * Constantes::TPS, 2);
    }

    public function calculTVQ($total)
    {
        $this->tvq = round($total * Constantes::TVQ, 2);
    }

    public function calculSommeTotal()
    {
        $this->sommeTotal = $this->total + $this->tps + $this->tvq + Constantes::FRAIS_LIVRAISON;
    }
}
