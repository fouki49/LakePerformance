<?php

namespace App\Entity;
use App\Repository\AchatRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AchatRepository::class)]
#[ORM\Table(name: 'achats')]
class Achat
{

    private $quantite;
    // private $produit;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name:'idAchat')]
    private ?int $idAchat = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(name: 'idProduit', referencedColumnName: 'idProduit')]
    private ?Produit $produit = null;
    


    #[ORM\ManyToOne(inversedBy: "commandes")]
    #[ORM\JoinColumn(name: 'idCommande', referencedColumnName: 'idCommande')]
    private ?Commande $commande = null;



    public function __construct($produit)
    {
        $this->quantite = Constantes::QUANTITE;
        $this->produit = $produit;
    }

    public function getIdAchat(): ?int
    {
        return $this->idAchat;
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

    public function getProduit(): ?Produit
    {
        return $this->produit;
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
}
