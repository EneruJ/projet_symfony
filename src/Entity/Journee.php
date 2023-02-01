<?php

namespace App\Entity;

use App\Repository\JourneeRepository;
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

    #[ORM\ManyToOne(inversedBy: 'journees')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $organisateur = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $niveau = null;

    #[ORM\OneToOne(mappedBy: 'journee', cascade: ['persist', 'remove'])]
    private ?Participants $participants = null;

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

    public function getOrganisateur(): ?User
    {
        return $this->organisateur;
    }

    public function setOrganisateur(?User $organisateur): self
    {
        $this->organisateur = $organisateur;

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

    public function getParticipants(): ?Participants
    {
        return $this->participants;
    }

    public function setParticipants(Participants $participants): self
    {
        // set the owning side of the relation if necessary
        if ($participants->getJournee() !== $this) {
            $participants->setJournee($this);
        }

        $this->participants = $participants;

        return $this;
    }
}
