<?php

namespace App\Entity;

class Achat
{

    private $quantite;
    private $prixAchat;
    private $produit;

    public function __construct($quantite, $prixAchat, $produit)
    {
        $this->quantite = $quantite;
        $this->prixAchat = $prixAchat;
        $this->produit = $produit;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function getPrixAchat()
    {
        return $this->prixAchat;
    }

    public function getProduit() {
        return $this->produit;
    }
}
