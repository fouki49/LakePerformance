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

    public function updateAchat($newAchat)
    {
        if(count($this->achats) > 0) {
            $achatQauntite = $newAchat["txtQuantiteAchat"];
            $prixAchat = $newAchat["lblPrixAchat"];
    
            foreach($this->achats as $key => $achat) {
                $newQuantite = $achatQauntite[$key];
                //TODO : faire en sorte je pense qu'on multiplie le prix par la quantite
                $newPrixAchat = $prixAchat[$key] * $achatQauntite[$key];
                $achat->update($newQuantite, $newPrixAchat);
            }
        }
    }

    public function getAchats()
    {
        return $this->achats;
    }
}
