<?php

namespace App\Controller;

use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
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

    private function retrieveAllProducts()
    {

        return $this->em->getRepository(Produit::class)->findAll();
    }
}
