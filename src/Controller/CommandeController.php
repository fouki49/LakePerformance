<?php

namespace App\Controller;

use App\Core\Notification;
use App\Core\NotificationColor;
use App\Entity\Commande;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CommandeController extends AbstractController
{
    private $em = null;
    private $haveCommand = true;


    #[Route('/commande/{idCommande}', name: 'app_commande')]
    public function index($idCommande, Request $request, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $this->em = $doctrine->getManager();

        $commande = $this->em->getRepository(Commande::class)->find($idCommande);

        if ($commande == null) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('commande/index.html.twig', [
            'search_category' => $request->query->get('category'),
            'commandes' => $commande
        ]);
    }



    #[Route('/mycommands', name: 'app_mycommands')]
    public function myCommandsView(Request $request, ManagerRegistry $doctrine): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $this->em = $doctrine->getManager();
        $user = $this->getUser();

        $commande = $this->em->getRepository(Commande::class)->findBy(['client' => $user->getIdClient()]);

        if ($commande == null) {
            $this->haveCommand = false;
            $this->addFlash(
                'mycommands',
                new Notification('error', 'You have not order anythig yet...', NotificationColor::WARNING)
            );
        }

        return $this->render('commande/mycommandes.html.twig', [
            'search_category' => $request->query->get('category'),
            'commandes' => $commande,
            'haveCommand' => $this->haveCommand
        ]);
    }
}
