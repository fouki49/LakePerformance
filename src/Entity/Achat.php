<?php

namespace App\Entity;

class Achat
{

    private $quantite;
    private $produit;

    public function __construct($produit)
    {
        $this->quantite = Constantes::QUANTITE;
        $this->produit = $produit;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function updateAchat($quantite)
    {
        $this->quantite = $quantite;
    }

    public function verifyIfQuantityIsEmpty($quantite)
    {
        if ($quantite == 0) {
            return true;
        }
        return false;
    }

    public function getNewQuantite()
    {
        $this->quantite = $this->quantite + 1;

        return $this->quantite;
    }


    public function getPrixAchat()
    {
        $prix = $this->produit->getPrix() * $this->quantite;
        return $prix;
    }

    public function getProduit()
    {
        return $this->produit;
    }
}
