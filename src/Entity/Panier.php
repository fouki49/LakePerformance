<?php

namespace App\Entity;

class Panier
{

    private $achats = [];

    public function ajouterAchat($quantite, $produit)
    {
        $achat = new Achat($quantite, $produit);
        $this->achats[] = $achat;
    }

    public function supprimerAchat($index)
    {
        if (array_key_exists($index, $this->achats)) {
            unset($this->achats[$index]);
        }
    }

    public function getAchats()
    {
        return $this->achats;
    }
}
