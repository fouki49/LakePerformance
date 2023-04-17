<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class ContactController extends AbstractController
{
    #[Route('/contact', name: 'route_contact')]
    public function index(Request $request): Response
    {
        return $this->render('contact/index.html.twig', [
            'search_category' => $request->query->get('category')
        ]); 
    }
}
