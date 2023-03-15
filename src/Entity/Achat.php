<?php

namespace App\Entity;

class Achat
{

    private $quantite;
    private $prixAchat;
    private $produit;

    public function __construct($quantite, $produit)
    {
        $this->quantite = $quantite;
        $this->produit = $produit;
    }

    public function getQauntite()
    {
        return $this->quantite;
    }

    public function getprixAchat()
    {
        return $this->prixAchat;
    }

    public function getProduit() {
        return $this->produit;
    }
}
