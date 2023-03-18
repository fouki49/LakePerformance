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


    #[Route('/panier', name: 'app_panier')]
    public function index(Request $request): Response
    {
        $this->initSession($request);
        $session = $request->getSession();

        return $this->render('panier/panier.html.twig', [
            'name' => $session->get('name'),
            'achatlist' => $this->achatList,
            // TODO: Acceder au Constantes
            // 'fraislivraison' => $;
        ]);
    }

    #[Route('/panier/ajout/{idProduit}', name: 'app_ajout_panier',  methods: ['POST'])]
    public function addAchat($idProduit, Request $request, ManagerRegistry $doctrine): Response
    {
        $this->initSession($request);
        $post = $request->request->all();

        $this->em = $doctrine->getManager();

        $produit = $this->em->getRepository(Produit::class)->find($idProduit);
        $this->achatList->ajouterAchat(1, $produit);

        //Validation
        if ($post) {
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
        // $post = $request->request->all();
        $this->initSession($request);

        $action = $request->request->get('action');

        // if($action == "update") {
        //     $this->todoList->update($post);
        //     $this->addFlash('todo', 
        //         new Notification('success', 'Tâches sauvegardées', NotificationColor::INFO));
        // } else 
        if ($action == "empty") {
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
}
