<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Scheb\TwoFactorBundle\Model\Google\TwoFactorInterface as GoogleAuthenticatorInterface;

#[ORM\Entity(repositoryClass: EmployeRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class Employe implements UserInterface, PasswordAuthenticatedUserInterface, GoogleAuthenticatorInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'employe_id', type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 180,unique: true) ]
    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    private ?string $email = null;



    #[ORM\Column(length: 255)]
    private ?string $typeContrat = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateEntree = null;

    #[ORM\Column(type: Types::SMALLINT)]
    private ?int $actif = 1;


    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }


    public function getTypeContrat(): ?string
    {
        return $this->typeContrat;
    }

    public function setTypeContrat(string $typeContrat): static
    {
        $this->typeContrat = $typeContrat;

        return $this;
    }

    public function getDateEntree(): ?\DateTimeInterface
    {
        return $this->dateEntree;
    }

    public function setDateEntree(\DateTimeInterface $dateEntree): static
    {
        $this->dateEntree = $dateEntree;

        return $this;
    }

    public function getActif(): ?int
    {
        return $this->actif;
    }

    public function setActif(int $actif): static
    {
        $this->actif = $actif;

        return $this;
    }

    /**
     * @var Collection<int, Projet>
     */
    #[ORM\ManyToMany(targetEntity: Projet::class, mappedBy: 'employes')]
    private Collection $projets;


    /**
     * @var Collection<int, Tache>
     */
    #[ORM\OneToMany(targetEntity: Tache::class, mappedBy: 'employe')]
    private Collection $taches;
    public function __construct()
    {
        $this->projets = new ArrayCollection();
        $this->taches = new ArrayCollection();
        $this->typeContrat = 'CDI';
        $this->dateEntree = new \DateTime();
        $this->roles = ['ROLE_USER'];
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProjets(): Collection
    {
        return $this->projets;
    }

    public function addProjet(Projet $projet): static
    {
        if (!$this->projets->contains($projet)) {
            $this->projets->add($projet);
            $projet->addEmploye($this);
        }
        return $this;
    }

    public function removeProjet(Projet $projet): static
    {
        if ($this->projets->removeElement($projet)) {
            $projet->removeEmploye($this);
        }
        return $this;
    }

    /**
     * @return Collection<int, Tache>
     */
    public function getTaches(): Collection
    {
        return $this->taches;
    }

    public function addTache(Tache $tache): static
    {
        if (!$this->taches->contains($tache)) {
            $this->taches->add($tache);
            $tache->setEmploye($this);
        }
        return $this;
    }

    public function removeTache(Tache $tache): static
    {
        if ($this->taches->removeElement($tache)) {
            if ($tache->getEmploye() === $this) {
                $tache->setEmploye(null);
            }
        }
        return $this;
    }



    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
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
     *
     * @return list<string>
     */
    public function getRoles(): array
    {
        return $this->roles ?? [];
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles($roles): static
    {
        $this->roles = is_array($roles) ? $roles : [$roles];
        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }


    //2FA///

    #[ORM\Column(type: 'string', nullable: true)]
    private ?string $googleAuthenticatorSecret = null;


    // [...]

    public function isGoogleAuthenticatorEnabled(): bool
    {
        return null !== $this->googleAuthenticatorSecret;
    }

    public function getGoogleAuthenticatorUsername(): string
    {
        return $this->email;
    }

    public function getGoogleAuthenticatorSecret(): ?string
    {
        return $this->googleAuthenticatorSecret;
    }

    public function setGoogleAuthenticatorSecret(?string $googleAuthenticatorSecret): void
    {
        $this->googleAuthenticatorSecret = $googleAuthenticatorSecret;
    }



}
