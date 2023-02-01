<?php

namespace App\Entity;

use App\Repository\JourneeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: JourneeRepository::class)]
class Journee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column(length: 255)]
    private ?string $lieu = null;

    #[ORM\Column]
    private ?int $nb_participants_max = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $niveau = null;

    #[ORM\OneToMany(mappedBy: 'journee', targetEntity: UserJournee::class)]
    private Collection $userJournees;

    #[ORM\ManyToOne(inversedBy: 'journees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $organisateur = null;

    public function __construct()
    {
        $this->userJournees = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getNbParticipantsMax(): ?int
    {
        return $this->nb_participants_max;
    }

    public function setNbParticipantsMax(int $nb_participants_max): self
    {
        $this->nb_participants_max = $nb_participants_max;

        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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

    /**
     * @return Collection<int, UserJournee>
     */
    public function getUserJournees(): Collection
    {
        return $this->userJournees;
    }

    public function addUserJournee(UserJournee $userJournee): self
    {
        if (!$this->userJournees->contains($userJournee)) {
            $this->userJournees->add($userJournee);
            $userJournee->setJournee($this);
        }

        return $this;
    }

    public function removeUserJournee(UserJournee $userJournee): self
    {
        if ($this->userJournees->removeElement($userJournee)) {
            // set the owning side to null (unless already changed)
            if ($userJournee->getJournee() === $this) {
                $userJournee->setJournee(null);
            }
        }

        return $this;
    }

    public function getOrganisateur(): ?User
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?User $organisateur): self
    {
        $this->organisateur = $organisateur;

        return $this;
    }


}
