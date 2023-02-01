<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $niveau = null;

    #[ORM\Column]
    private ?int $pts_comp = null;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    #[ORM\OneToMany(mappedBy: 'organisateur', targetEntity: Journee::class)]
    private Collection $journees;

    #[ORM\ManyToMany(targetEntity: Participants::class, mappedBy: 'participant')]
    private Collection $participations;

    public function __construct()
    {
        $this->journees = new ArrayCollection();
        $this->participations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

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

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): self
    {
        $this->niveau = $niveau;

        return $this;
    }

    public function getPtsComp(): ?int
    {
        return $this->pts_comp;
    }

    public function setPtsComp(int $pts_comp): self
    {
        $this->pts_comp = $pts_comp;

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

    /**
     * @return Collection<int, Journee>
     */
    public function getJournees(): Collection
    {
        return $this->journees;
    }

    public function addJournee(Journee $journee): self
    {
        if (!$this->journees->contains($journee)) {
            $this->journees->add($journee);
            $journee->setOrganisateur($this);
        }

        return $this;
    }

    public function removeJournee(Journee $journee): self
    {
        if ($this->journees->removeElement($journee)) {
            // set the owning side to null (unless already changed)
            if ($journee->getOrganisateur() === $this) {
                $journee->setOrganisateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Participants>
     */
    public function getParticipations(): Collection
    {
        return $this->participations;
    }

    public function addParticipation(Participants $participation): self
    {
        if (!$this->participations->contains($participation)) {
            $this->participations->add($participation);
            $participation->addParticipant($this);
        }

        return $this;
    }

    public function removeParticipation(Participants $participation): self
    {
        if ($this->participations->removeElement($participation)) {
            $participation->removeParticipant($this);
        }

        return $this;
    }
}
