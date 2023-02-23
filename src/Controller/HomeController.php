<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    private $em = null;
    #[Route('/', name: 'app_home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $this->em = $doctrine->getManager();

        $products = $this->retrieveAllProducts();

        return $this->render('home/index.html.twig', [
            'products' => $products,
        ]);
    }

    //test pour mes filtre 
    #[Route('/produits/{idProduit}', name: 'produit_modal')]
    public function infoChampion($idProduit, Request $request, ManagerRegistry $doctrine): Response
    {
        //2 Philosophies -> JSON, HTML

        $this->em = $doctrine->getManager();

        $produit = $this->em->getRepository(Champion::class)->find($idProduit);

        return $this->render('home/champion.modal.twig', ['champion' => $produit]);
    }

    private function retrieveAllProducts()
    {
        return $this->em->getRepository(Produit::class)->findAll();
    }
}
