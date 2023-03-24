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

        return $this->render('panier/panier.html.twig', [
            'name' => $session->get('name'),
            'achatlist' => $this->achatList,
            'fraislivraison' => $fraisLivraison,
            'total' => $this->total,
            'tps' => $this->tps,
            'tvq' => $this->tvq,
            'sommetotal' => $this->sommeTotal
        ]);
    }

    #[Route('/panier/ajout/{idProduit}', name: 'app_ajout_panier',  /*methods: ['POST']*/)]
    public function addAchat($idProduit, Request $request, ManagerRegistry $doctrine): Response
    {
        $this->initSession($request);
        // $post = $request->request->all();

        $this->em = $doctrine->getManager();

        $produit = $this->em->getRepository(Produit::class)->find($idProduit);
        // $this->achatList->ajouterAchat(Constantes::QUANTITE, $produit->getPrix(), $produit);

        if ($this->achatList->getAchats() == null) {
            $this->achatList->ajouterAchat(Constantes::QUANTITE, $produit->getPrix(), $produit);
        }

        foreach ($this->achatList->getAchats() as $achat) {

            // echo "id produit ";
            // echo $produit->getIdProduit();
            // echo "  id achat ";
            // echo $achat->getProduit()->getIdProduit();
            // die();

            // echo "nom produit ";
            // echo $produit->getNom();
            // echo "  nom achat ";
            // echo $achat->getProduit()->getNom();
            // die();

            if ($produit->getIdProduit() == $achat->getProduit()->getIdProduit()) {
                //TODO: incrementation de la quantite du produit

                //TODO: afficher une notification
                break;
            } else {
                //TODO : ajouter le produit
                //TODO: afficher une notification
                $this->achatList->ajouterAchat(Constantes::QUANTITE, $produit->getPrix(), $produit);
            }
            return $this->redirectToRoute('app_panier');
        }

        return $this->redirectToRoute('app_panier');
    }


    #[Route('/panier/supprimer/{idProduit}', name: 'app_delete_achat')]
    public function deleteAchat($idProduit, Request $request): Response
    {
        $this->initSession($request);

        $this->achatList->supprimerAchat($idProduit);

        return $this->redirectToRoute('app_panier');
    }

    #[Route('/panier/update', name: 'app_update_achat', methods: ['POST'])]
    public function updateTodo(Request $request): Response
    {
        $post = $request->request->all();
        $this->initSession($request);

        $action = $request->request->get('action');

        if($action == "update") {
            $this->achatList->updateAchat($post);
            // $this->addFlash('todo', 
            //     new Notification('success', 'Tâches sauvegardées', NotificationColor::INFO));
        } else if($action == "empty") {
            $session = $request->getSession();
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

    // public function retrieveAllAchatIdProduct()
    // {
    //     foreach ($this->achatList->getAchats() as $achat) {
    //         $id = $achat->getProduit()->getIdProduit();
    //         array_push($this->idProductInAchatList, $id);
    //     }
    //     return $this->redirectToRoute('app_panier');

    // }

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
