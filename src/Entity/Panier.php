<?php

namespace App\Entity;

class Panier
{

    private $achats = [];
    private $produit;
    private $total;
    private $tps;
    private $tvq;
    private $sommeTotal;

    public function __construct($achatsInit = null)
    {
        if (empty($achatsInit)) return; // Si panier est vide bye bye.

        $this->achats = $achatsInit;

        $this->retrieveAllAchatListPrices();
        $this->calculTPS($this->total);
        $this->calculTVQ($this->total);
        $this->calculSommeTotal();
    }
    public function ajouterAchat($produit)
    {
        $achat = new Achat($produit);
        $this->achats[] = $achat;
    }

    public function supprimerAchat($idProduit)
    {
        if (array_key_exists($idProduit, $this->achats)) {
            unset($this->achats[$idProduit]);
        }
    }

    public function updateAchat($newAchat)
    {
        if (count($this->achats) > 0) {
            $achatQauntite = $newAchat["txtQuantiteAchat"];

            foreach ($this->achats as $key => $achat) {
                $newQuantite = $achatQauntite[$key];
                $achat->updateAchat($newQuantite);
            }
        }
    }

    public function validerExistanceDansPanier($idProduit)
    {
        foreach ($this->achats as $a) {
            if ($a->getProduit()->getIdProduit() == $idProduit) {
                return true;
            }
        }
        return false;
    }

    public function ajouterQuantitePanier($idProduit)
    {
        foreach ($this->achats as $a) {
            if ($a->getProduit()->getIdProduit() == $idProduit) {
                $a->getNewQuantite();
            }
        }
    }

    public function getAchats()
    {
        return $this->achats;
    }

    public function getTVQ()
    {
        return $this->tvq;
    }

    public function getTPS()
    {
        return $this->tps;
    }

    public function getTotal()
    {
        return $this->total;
    }

    public function getSommeTotal()
    {
        return $this->sommeTotal;
    }

    //permet d'avoir acces a un produit
    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function retrieveAllAchatListPrices()
    {
        foreach ($this->getAchats() as $achat)
            $this->total += $achat->getPrixAchat();
    }

    public function calculTPS($total)
    {
        $this->tps = round($total * Constantes::TPS, 2);
    }

    public function calculTVQ($total)
    {
        $this->tvq = round($total * Constantes::TVQ, 2);
    }

    public function calculSommeTotal()
    {
        $this->sommeTotal = $this->total + $this->tps + $this->tvq + Constantes::FRAIS_LIVRAISON;
    }
}
