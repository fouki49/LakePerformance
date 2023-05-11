<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategoryCollection;
use App\Form\CategoryCollectionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

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

        $categories = $this->em->getRepository(Categorie::class)->findAll();
        $categoriesCollection = new CategoryCollection($categories);

        // $categoriesCollection = new Categorie($categories);

        $formCategories = $this->createForm(CategoryCollectionType::class, $categoriesCollection);

        $formCategories->handleRequest($request);

        if ($formCategories->isSubmitted() && $formCategories->isValid()) {
            // $newCollectionCategory = $formCategories->getData()->getCategories();

            $newCollectionCategory = $formCategories->getData()->getCategories();

            foreach ($newCollectionCategory as $newCategory) {
                // $newCategory->setCategorie($newCategory->getCategorie());
                $this->em->persist($newCategory);
                // dump($newCategory);
                //TODO : this work check a maison lmao
            }
            // die();
            $this->em->flush();
        }


        return $this->render('admin/adminCategories.html.twig', [
            'search_category' => $request->query->get('category'),
            'formCategories' => $formCategories
        ]);
    }

    #[Route('/admin/new/product', name: 'app_admin_new_product')]
    public function indexNewProduct(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');


        return $this->render('admin/adminNewProduct.html.twig', [
            'search_category' => $request->query->get('category'),
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

        //TODO: a verifier plus tard
        // if(!$this->isGranted('ROLE_ADMIN')) {
        //     dd("ca marche");
        //     //TODO : Quoi faire si je ne suis pas admin
        //     //Redirect
        //     return $this->redirectToRoute('/');
        // }


        return $this->render('admin/adminOrders.html.twig', [
            'search_category' => $request->query->get('category'),
        ]);
    }
}
