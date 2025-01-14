<?php

namespace App\Entity;

use App\Repository\AbonneRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonneRepository::class)]
class Abonne
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 200)]
    private ?string $name = null;

    #[ORM\Column(length: 200)]
    private ?string $firstname = null;

    #[ORM\Column(length: 200)]
    private ?string $fname = null;

    #[ORM\Column(length: 200)]
    private ?string $lname = null;

    #[ORM\Column(length: 255)]
    private ?string $tele = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $datetime = null;

    #[ORM\Column]
    private ?bool $activeSub = null;


    #[ORM\OneToOne(targetEntity: User::class, inversedBy: 'abonne', cascade: ['persist', 'remove'])]
    private ?User $user = null;



    #[ORM\OneToMany(mappedBy: 'abonne', targetEntity: Paiement::class, cascade: ['persist', 'remove'])]
    private Collection $paiements;

    public function __construct()
    {
        $this->paiements = new ArrayCollection();
}
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getFname(): ?string
    {
        return $this->fname;
    }

    public function setFname(string $fname): static
    {
        $this->fname = $fname;

        return $this;
    }

    public function getLname(): ?string
    {
        return $this->lname;
    }

    public function setLname(string $lname): static
    {
        $this->lname = $lname;

        return $this;
    }

    public function getTele(): ?string
    {
        return $this->tele;
    }

    public function setTele(string $tele): static
    {
        $this->tele = $tele;

        return $this;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): static
    {
        $this->datetime = $datetime;

        return $this;
    }

    public function isActiveSub(): ?bool
    {
        return $this->activeSub;
    }

    public function setActiveSub(bool $activeSub): static
    {
        $this->activeSub = $activeSub;

        return $this;
    }
    public function getUser(): ?User
    {
        return $this->user;
    }
    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }
    public function getPaiements(): Collection
    {
        return $this->paiements;
    }

    public function addPaiement(Paiement $paiement): self
    {
        if (!$this->paiements->contains($paiement)) {
            $this->paiements->add($paiement);
            $paiement->setAbonne($this);
        }

        return $this;
    }

    public function removePaiement(Paiement $paiement): self
    {
        if ($this->paiements->removeElement($paiement)) {
            if ($paiement->getAbonne() === $this) {
                $paiement->setAbonne(null);
            }
        }

        return $this;
    }
}