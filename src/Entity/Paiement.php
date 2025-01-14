<?php

namespace App\Entity;

use App\Repository\PaiementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaiementRepository::class)]
class Paiement
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $payDate = null;

    #[ORM\Column(length: 211)]
    private ?string $modePay = null;

    #[ORM\ManyToOne(targetEntity: Abonne::class, inversedBy: 'paiements')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Abonne $abonne = null;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getPayDate(): ?\DateTimeInterface
    {
        return $this->payDate;
    }

    public function setPayDate(\DateTimeInterface $payDate): static
    {
        $this->payDate = $payDate;

        return $this;
    }

    public function getModePay(): ?string
    {
        return $this->modePay;
    }

    public function setModePay(string $modePay): static
    {
        $this->modePay = $modePay;

        return $this;
    }
    public function getAbonne(): ?Abonne
    {
        return $this->abonne;
    }
    public function setAbonne(?Abonne $abonne):self
    {
        $this->abonne = $abonne;
        return $this;
    }
}