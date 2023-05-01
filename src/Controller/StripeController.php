<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Panier;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

use Stripe;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class StripeController extends AbstractController
{

    private $em = null;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->em = $doctrine->getManager();
    }

    #[Route('/stripe-checkout', name: 'stripe_checkout')]
    public function stripeCheckout(Request $request): Response
    {

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        //Nous sommes connectés

        $user = $this->getUser();
        $panier = new Panier($request->getSession()->get('achatlist')->getAchats());

        \Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);

        $successURL = $this->generateUrl('stripe_success', [], UrlGeneratorInterface::ABSOLUTE_URL) . "?stripe_id={CHECKOUT_SESSION_ID}";

        $sessionData = [
            'line_items' => [[
                'quantity' => 1,
                'price_data' => ['unit_amount' => $panier->getSommeTotal() * 100, 'currency' => 'CAD', 'product_data' => ['name' => 'Microtransaction CSTJ']]
            ]],
            'customer_email' => $user->getEmail(),
            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'success_url' => $successURL,
            'cancel_url' => $this->generateUrl('stripe_cancel', [], UrlGeneratorInterface::ABSOLUTE_URL)
        ];

        //Extension curl nécessaire 
        $checkoutSession = \Stripe\Checkout\Session::create($sessionData);
        return $this->redirect($checkoutSession->url, 303);
    }


    #[Route('/stripe-success', name: 'stripe_success')]
    public function stripeSuccess(Request $request): Response
    {
        //Nous avons un paiement
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $user = $this->getUser();

        try {

        //TODO: Valider que le paiement ait vraiment fonctionné chez stripe.
        //\Stripe\Stripe::setApiKey($_ENV["STRIPE_SECRET"]);
        $stripe = new \Stripe\StripeClient($_ENV["STRIPE_SECRET"]);

        $stripeSessionId = $request->query->get('stripe_id');
        $sessionStripe = $stripe->checkout->sessions->retrieve($stripeSessionId);
        $paymentIntent = $sessionStripe->payment_intent;


        //retrouver le panier en session
        $user = $this->getUser();
        $panier = new Panier($request->getSession()->get('achatlist')->getAchats());

        //Creation d'une commande
        $commande = new Commande($user, $panier, $paymentIntent);

        foreach ($commande->getAchats() as $achat) {

            $produit = $this->em->merge($achat->getProduit());
            $produit->vendre($achat->getQuantite());

            $achat->setProduit($produit);
        }

        $this->em->persist($commande);
        $this->em->flush();

        $request->getSession()->remove('achatlist');

        return $this->redirectToRoute('app_commande', ['idCommande' => $commande->getIdCommande()]);
        } catch (\Exception $e) {
            //TODO : Redirection
        }
        return $this->redirectToRoute('app_profile');
    }

    #[Route('/stripe-cancel', name: 'stripe_cancel')]
    public function stripeCancel(): Response
    {
        return $this->redirectToRoute('app_profile');
    }
}
