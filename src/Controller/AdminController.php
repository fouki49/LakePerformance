<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\Commande;
use App\Entity\Produit;
use App\Form\CategoryCollection;
use App\Form\CategoryCollectionType;
use App\Form\NewProduitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\ORM\Exception\ORMException;


class AdminController extends AbstractController
{

    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    #[Route('/admin/categories', name: 'app_admin_categories')]
    public function indexCategory(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_home');
        }

        $categories = $this->em->getRepository(Categorie::class)->findAll();
        $categoriesCollection = new CategoryCollection($categories);

        $formCategories = $this->createForm(CategoryCollectionType::class, $categoriesCollection);
        $formCategories->handleRequest($request);

        if ($formCategories->isSubmitted() && $formCategories->isValid()) {

            $newCollectionCategory = $formCategories->getData()->getCategories();

            foreach ($newCollectionCategory as $newCategory) {
                $this->em->persist($newCategory);
            }
            $this->em->flush();
        }


        return $this->render('admin/adminCategories.html.twig', [
            'search_category' => $request->query->get('category'),
            'formCategories' => $formCategories
        ]);
    }

    #[Route('/admin/new/product', name: 'app_admin_new_product')]
    public function indexNewProduct(Request $request, SluggerInterface $slugger): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $produit = new Produit();

        $formNewProduit = $this->createForm(NewProduitType::class, $produit);
        $formNewProduit->handleRequest($request);

        if ($formNewProduit->isSubmitted() && $formNewProduit->isValid()) {
            
            $productImage = $formNewProduit->get('imagePath')->getData();

            if($productImage) {
                $originalFilename = pathinfo($productImage->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . "-" . uniqid() . ".". $productImage->guessExtension(); 

                try {
                    $productImage->move(
                        $this->getParameter('product_picture'),
                        $newFilename);

                        $produit->setImagePath($newFilename);

                    $this->em->persist($produit);
                    $this->em->flush();

                } catch(FileException $e) {
                    //TODO: Erreur
                } catch(ORMException $e) {
                    //TODO: Erreur
                }
            }
        }
        return $this->render('admin/adminNewProduct.html.twig', [
            'search_category' => $request->query->get('category'),
            'formNewProduit' => $formNewProduit
        ]);
    }

    #[Route('/admin/products', name: 'app_admin_products')]
    public function indexProducts(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');


        return $this->render('admin/adminProducts.html.twig', [
            'search_category' => $request->query->get('category'),
        ]);
    }

    #[Route('/admin/orders', name: 'app_admin_orders')]
    public function indexOrdors(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        if (!$this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_home');
        }

        $commandes = $this->em->getRepository(Commande::class)->findAll();

        return $this->render('admin/adminOrders.html.twig', [
            'search_category' => $request->query->get('category'),
            'commandes' => $commandes
        ]);
    }
}
