<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
#[ORM\Table(name: 'categories')]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idCategorie')]
    private ?int $idCategorie = null;

    //pour l'ordre
    #[ORM\Column(name: 'sortOrder')]
    private ?int $sortOrder = null;

    #[ORM\OneToMany(targetEntity:Produit::class, mappedBy: "mainCategorie", fetch: "LAZY")]
    private $produits;

    #[ORM\Column(length: 25)]
    private ?string $categorie = null;

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

    public function getSortOrder(): ?int
    {
        return $this->sortOrder;
    }

    public function setSortOrder(int $sortOrder): self
    {
        $this->sortOrder = $sortOrder;

        return $this;
    }

    public function getChampions() : Collection {
        return $this->produits;
    }
}
