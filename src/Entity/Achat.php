<?php

namespace App\Entity;

class Achat
{

    private $quantite;
    private $prixAchat;

    public function __construct($quantite, $prixAchat)
    {
        $this->quantite = $quantite;
        $this->prixAchat = $prixAchat;
    }

    public function getQauntite()
    {
        return $this->quantite;
    }

    public function getprixAchat()
    {
        return $this->prixAchat;
    }
}
