<?php

namespace App\Entity;

class Panier
{
    
    private $achats = [];

    public function ajouterAchat($quantite,$prixAchat, $produit)
    {
        $achat = new Achat($quantite, $prixAchat, $produit);
        $this->achats[] = $achat;
        
    }

    public function supprimerAchat($idProduit)
    {
        if (array_key_exists($idProduit, $this->achats)) {
            unset($this->achats[$idProduit]);
        }
    }

    public function getAchats()
    {
        return $this->achats;
    }
}
