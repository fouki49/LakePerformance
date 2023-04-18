<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
#[ORM\Table(name: 'clients')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Client implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'idClient')]
    private ?int $idClient = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\Length(min: 6, minMessage: "Your password must contain at least {{ limit }} characters")]
    #[Assert\Length(max: 100, maxMessage: "Your password must contain at most {{ limit }} characters")]
    private ?string $password = null;



    #[ORM\Column(length: 50)]
    #[Assert\Length(min: 2, minMessage: "Your lastname must contain at least {{ limit }} characters")]
    #[Assert\Length(max: 30, maxMessage: "Your lastname must contain at most {{ limit }} characters")]
    private ?string $nom = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(min: 2, minMessage: "Your firstname must contain at least {{ limit }} characters")]
    #[Assert\Length(max: 30, maxMessage: "Your firstname must contain at most {{ limit }} characters")]
    private ?string $prenom = null;

    #[ORM\Column(length: 150)]
    #[Assert\Length(min: 5, minMessage: "The adress must contain at least {{ limit }} characters")]
    #[Assert\Length(max: 100, maxMessage: "The adress must contain at most {{ limit }} characters")]
    private ?string $adresse = null;

    #[ORM\Column(length: 50)]
    #[Assert\Length(min: 5, minMessage: "The city must contain at least {{ limit }} characters")]
    #[Assert\Length(max: 100, maxMessage: "The city must contain at most {{ limit }} characters")]
    private ?string $ville = null;

    #[ORM\Column(name: 'codePostal', length: 10)]
    #[Assert\Regex(pattern: "/^[ABCEGHJKLMNPRSTVXY][0-9][ABCEGHJKLMNPRSTVWXYZ][-][0-9][ABCEGHJKLMNPRSTVWXYZ][0-9]$/", message: "Postal code must respect those conditions (Must be 6 letters or characters. Not leading by W-Z or contain D, F, I, O, Q or U)'")]
    private ?string $codePostal = null;

    #[ORM\Column(length: 5)]
    private ?string $province = null;

    #[ORM\Column(nullable: true)]
    #[Assert\Regex(pattern: "/^[0-9]{10}$/", message: "Your phone number must contain 10 numbers")]
    private ?string $telephone = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;


   

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getIdClient(): ?int
    {
        return $this->idClient;
    }

    public function setIdClient(int $idClient): self
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;

        return $this;
    }

    public function getProvince(): ?string
    {
        return $this->province;
    }

    public function setProvince(string $province): self
    {
        $this->province = $province;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }
    public function isVerified(): bool
    {
        return $this->isVerified;
    }
    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
