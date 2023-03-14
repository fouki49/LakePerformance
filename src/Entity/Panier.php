<?php

namespace App\Entity;

class Panier
{

    private $achats = [];

    public function ajouterAchat($quantite, $prixAchat)
    {
        $achat = new Achat($quantite, $prixAchat);
        $this->achats[] = $achat;
    }

    public function supprimerAchat($index)
    {
        if(array_key_exists($index, $this->achats)) {
            unset($this->achats[$index]);
        }
    }

    public function getAchat()
    {
        return $this->achats;
    }
}
