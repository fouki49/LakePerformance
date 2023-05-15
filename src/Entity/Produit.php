<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
#[ORM\Table(name: 'produits')]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idProduit')]
    private ?int $idProduit = null;

    #[ORM\Column(length: 25)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\Column(nullable: true, name: 'quantiteEnStock')]
    private ?int $quantiteEnStock = null;

    #[ORM\Column(length: 1000)]
    private ?string $description = null;

    #[ORM\Column(length: 100, name: 'imagePath')]
    private ?string $imagePath = null;


    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: "produits", cascade: ["persist"], fetch: "EAGER")]
    #[ORM\JoinColumn(name: 'idCategorie', referencedColumnName: 'idCategorie')]
    private $idCategorie;

    public function getIdProduit(): ?int
    {
        return $this->idProduit;
    }

    public function setIdProduit(Int $idProduit): self
    {
        $this->idProduit = $idProduit;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(String $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function vendre($quantiteAchat)
    {
        return $this->quantiteEnStock -= $quantiteAchat;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(Float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function setQuantiteEnStock(Int $quantiteEnStock): self
    {
        $this->quantiteEnStock = $quantiteEnStock;

        return $this;
    }

    public function getQuantiteEnStock(): ?int
    {
        return $this->quantiteEnStock;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(String $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIdCategorie(): ?Categorie
    {
        return $this->idCategorie;
    }

    public function setIdCategorie(?Categorie $idCategorie): self
    {
        $this->idCategorie = $idCategorie;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(String $imagePath): self
    {
        $this->imagePath = $imagePath;

        return $this;
    }
}
