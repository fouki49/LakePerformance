<?php

namespace App\Controller;

use App\Entity\Categorie;
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
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $this->em = $doctrine->getManager();

        $products = $this->retrieveAllProducts();

        $category = $request->query->get('category'); // $_GET['category']
        $categories = $this->retrieveAllCategories();
        $searchField = $request->request->get('search_field');
        $products = $this->retrieveProductsFromCategory($category, $searchField);

        return $this->render('home/index.html.twig', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    //test pour mes filtre 
    #[Route('/produits/{idProduit}', name: 'product_modal')]
    public function infoProduit($idProduit, Request $request, ManagerRegistry $doctrine): Response
    {
        $this->em = $doctrine->getManager();

        $produit = $this->em->getRepository(Produit::class)->find($idProduit);

        return $this->render('home/product.modal.twig', ['produit' => $produit]);
    }

    private function retrieveAllProducts()
    {
        return $this->em->getRepository(Produit::class)->findAll();
    }

    private function retrieveAllCategories()
    {
        return $this->em->getRepository(Categorie::class)->findAll();
    }

    private function retrieveProductsFromCategory($category, $searchField)
    {
        return $this->em->getRepository(Produit::class)->findWithCriteria($category, $searchField);
    }
}
