<?php

namespace App\Controller;

use App\Entity\Achat;
use App\Entity\Commande;
use App\Entity\Produit;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    private $em = null;
    private $achatCommandeList;


    #[Route('/commande/{idCommande}', name: 'app_commande')]
    public function index($idCommande, Request $request, ManagerRegistry $doctrine): Response
    {
        // $produit = $this->em->getRepository(Produit::class)->find('1');
        // $this->achatCommandeList = $session->get('achatcommandelist', new Achat($produit));
        // $session->set('achatcommandelist', $this->achatCommandeList);


        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


        $this->em = $doctrine->getManager();

        // $user = $this->getUser();

        $commande = $this->em->getRepository(Commande::class)->find($idCommande);



        // dd($commande->getAchats());

        return $this->render('commande/index.html.twig', [
            'search_category' => $request->query->get('category'),
            'commandes' => $commande
        ]);
    }


    private function initSession(Request $request, ManagerRegistry $doctrine)
    {
        // $session = $request->getSession();
        // $session->set('name', 'Benjamin');

        // $user = $this->getUser();
        // $panier = new Panier($request->getSession()->get('achatlist')->getAchats());


        // $stripe = new \Stripe\StripeClient($_ENV["STRIPE_SECRET"]);

        // $stripeSessionId = $request->query->get('stripe_id');
        // $sessionStripe = $stripe->checkout->sessions->retrieve($stripeSessionId);
        // $paymentIntent = $sessionStripe->payment_intent;

        // $this->commandList = $session->get('commandlist', new Commande($user, $panier, $paymentIntent));

        // $session->set('commandlist', $this->commandList);

        $session = $request->getSession();
        $session->set('name', 'Benjamin');

        $this->em = $doctrine->getManager();
        $produit = $this->em->getRepository(Produit::class)->findAll();

        $this->achatCommandeList = $session->get('achatcommandelist', new Achat($produit));

        $session->set('achatcommandelist', $this->achatCommandeList);
    }
}
