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

    #[ORM\OneToMany(targetEntity: Produit::class, mappedBy: "idCategorie", fetch: "LAZY")]
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
}
