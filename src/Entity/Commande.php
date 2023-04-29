<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

use function PHPUnit\Framework\stringContains;

#[ORM\Table(name: 'commandes')]
#[ORM\Entity(repositoryClass: CommandeRepository::class)]
class Commande
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idCommande')]
    private ?int $idCommande = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, name: 'dateCommande')]
    private ?\DateTimeInterface $dateCommande = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, name: 'dateLivraison', nullable:true)]
    private ?\DateTimeInterface $dateLivraison = null;

    #[ORM\Column(name: 'tauxTPS')]
    private ?float $tauxTPS = null;

    #[ORM\Column(name: 'tauxTVQ')]
    private ?float $tauxTVQ = null;

    #[ORM\Column(name: 'fraisLivraison')]
    private ?float $fraisLivraison = null;

    #[ORM\Column(length: 50)]
    private ?string $etat = null;

    #[ORM\Column(length: 255, name: 'stripeIntent')]
    private ?string $stripeIntent = null;

    #[ORM\ManyToOne(targetEntity: Client::class, inversedBy: "commandes", cascade: ["persist"])]
    #[ORM\JoinColumn(name: 'idClient', referencedColumnName: 'idClient')]
    private ?Client $client = null;

    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: Achat::class, orphanRemoval: true, cascade: ['persist'])]
    private Collection $achats;


    public function __construct($user, $panier, $stripeIntent)
    {
        $this->client = $user;
        $this->tauxTPS = Constantes::TPS;
        $this->tauxTVQ = Constantes::TVQ;
        $this->stripeIntent = $stripeIntent;
        $this->dateCommande = new DateTime();
        $this->dateCommande->getTimezone();
        $this->achats = new ArrayCollection();
        foreach($panier->getAchats() as $achats) {
            $this->achats->add($achats);
            $achats->setCommande($this);
        }
        $this->etat = "En Préparation";
        $this->dateLivraison = null;
        $this->fraisLivraison = Constantes::FRAIS_LIVRAISON;
    }


    public function getIdCommande(): ?int
    {
        return $this->idCommande;
    }

    public function getDateFormat() {
        return $this->dateCommande->format('Y-m-d h:i:s');
    }

    public function getIdClient(): ?int
    {
        return $this->client;
    }

    public function setIdClient(int $idClient): self
    {
        $this->client = $idClient;

        return $this;
    }

    public function getDateCommande(): ?\DateTimeInterface
    {
        return $this->dateCommande;
    }

    public function setDateCommande(\DateTimeInterface $dateCommande): self
    {
        $this->dateCommande = $dateCommande;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->dateLivraison;
    }

    public function setDateLivraison(\DateTimeInterface $dateLivraison): self
    {
        $this->dateLivraison = $dateLivraison;

        return $this;
    }

    public function getTauxTPS(): ?float
    {
        return $this->tauxTPS;
    }

    public function setTauxTPS(float $tauxTPS): self
    {
        $this->tauxTPS = $tauxTPS;

        return $this;
    }

    public function getTauxTVQ(): ?float
    {
        return $this->tauxTVQ;
    }

    public function setTauxTVQ(float $tauxTVQ): self
    {
        $this->tauxTVQ = $tauxTVQ;

        return $this;
    }

    public function getFraisLivraison(): ?float
    {
        return $this->fraisLivraison;
    }

    public function setFraisLivraison(float $fraisLivraison): self
    {
        $this->fraisLivraison = $fraisLivraison;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;
        return $this;
    }

    public function getStripeIntent(): ?string
    {
        return $this->stripeIntent;
    }

    public function setStripeIntent(string $stripeIntent): self
    {
        $this->stripeIntent = $stripeIntent;

        return $this;
    }

    public function getAchats(): Collection
    {
        return $this->achats;
    }

    public function getSommeAchats()
    {
        $prix = 0;
        foreach($this->achats as $achat){
            $prix = $prix + $achat->getPrixAchat();
        }
        return $prix;
    }

    public function getSommeTotalAchats()
    {
        // $prix = 0;
        // foreach($this->achats as $achat){
        //     $prix = $prix + $achat->getPrixAchat();
        // }
        // return $prix;
    }

    public function addAchats(Achat $achat): self
    {
        if (!$this->achats->contains($achat)) {
            $this->achats->add($achat);
            $achat->setCommande($this);
        }

        return $this;
    }

    public function removeAchats(Achat $achat): self
    {
        if ($this->achats->removeElement($achat)) {
            // set the owning side to null (unless already changed)
            if ($achat->getCommande() === $this) {
                $achat->setCommande(null);
            }
        }

        return $this;
    }
}
