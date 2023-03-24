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

    public function updateAchat($quantite){
        $this->quantite = $quantite;
    }

    
    public function getPrixAchat()
    {   
        $prix = $this->prixAchat * $this->quantite;
        return $prix;
    }

    public function getProduit() {
        return $this->produit;
    }
}
