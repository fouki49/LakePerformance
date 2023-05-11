<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ORM\Table(name: 'categories')]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idCategorie')]
    private ?int $idCategorie = null;

    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: "idCategorie", fetch: "LAZY", cascade: ["persist"])]
    private $produits;

    #[ORM\Column(length: 25)]
    private ?string $categorie = null;

    // public function __construct($categorie)
    // {
    //     $this->categorie = new ArrayCollection($categorie);
    // }


    public function getIdCategorie(): ?int
    {
        return $this->idCategorie;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
