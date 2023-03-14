<?php

namespace App\Controller;

use App\Entity\Panier;
use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController {
    private $em = null;
    private $achatList;
    private $produit;

    #[Route('/panier', name: 'app_panier')]
    public function index(Request $request) : Response {
        $this->initSession($request);
        $session = $request->getSession();

      

        return $this->render('panier/panier.html.twig', [
            'name' => $session->get('name'),
            'achatlist' => $this->achatList
        ]);
    }

    #[Route('/panier/ajout/{idProduit}', name: 'app_ajout_panier',  methods:['POST'])]
    public function addAchat($idProduit, Request $request, ManagerRegistry $doctrine) : Response {
        $this->initSession($request);
        $post = $request->request->all();

        $this->em = $doctrine->getManager();

        $produit = $this->em->getRepository(Produit::class)->find($idProduit);
        

        //Validation
        if($post){}

        return $this->redirectToRoute('app_panier', ['produit' => $produit]);
       
    }

    private function initSession(Request $request) {

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
