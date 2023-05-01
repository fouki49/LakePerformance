<?php

namespace App\Entity;

use App\Repository\AchatRepository;
use Doctrine\ORM\Mapping as ORM;
use PHPUnit\TextUI\XmlConfiguration\Constant;

#[ORM\Entity(repositoryClass: AchatRepository::class)]
#[ORM\Table(name: 'achats')]
class Achat
{

    // private $produit;


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idAchat')]
    private ?int $idAchat = null;

    #[ORM\ManyToOne(cascade: ["persist"])]
    #[ORM\JoinColumn(name: 'idProduit', referencedColumnName: 'idProduit', nullable: false)]
    private ?Produit $produit = null;


    #[ORM\ManyToOne(inversedBy: 'achats')]
    #[ORM\JoinColumn(name: 'idCommande', referencedColumnName: 'idCommande', nullable: false)]
    private ?Commande $commande = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?float $prixAchat = null;



    public function __construct($produit)
    {
        $this->quantite = Constantes::QUANTITE;
        $this->prixAchat = $produit->getPrix();
        $this->produit = $produit;
    }

    public function getIdAchat(): ?int
    {
        return $this->idAchat;
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



    public function getSommeTotalAchats()
    {
        foreach ($this->produit as $produit) {
            $prix = $produit->getPrix() * $this->quantite;
        }
        $avecTPS = $prix * Constantes::TPS;
        $avecTPSTVQ = $avecTPS * Constantes::TVQ;
        $sommeTotal = $avecTPSTVQ + Constantes::FRAIS_LIVRAISON;
        return $sommeTotal;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }


    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function setPrixAchat(float $prixAchat): self
    {
        $this->prixAchat = $prixAchat;

        return $this;
    }
}
