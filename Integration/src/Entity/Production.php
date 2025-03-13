<?php

namespace App\Entity;

use App\Repository\ProductionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductionRepository::class)]
class Production
{
    public const TYPE_LAIT = 'lait';
    public const TYPE_OEUF = 'oeuf';
    public const TYPE_VIANDE = 'viande';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotNull(message: "La date ne peut pas être nulle.")]
    #[Assert\Type(\DateTimeInterface::class, message: "La date doit être une date valide.")]
    #[Assert\LessThanOrEqual("today", message: "la date ne peut pas être supérieur à la date d'aujourd'hui .")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateProd = null;


    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Assert\NotNull(message: "La quantité ne peut pas être nulle.")]
    #[ORM\Column]
    private ?float $quantiteProd = null;

    #[Assert\NotNull(message: "La qualité ne peut pas être nulle.")]
    #[ORM\Column(length: 255)]
    private ?string $qualiteProd = null;

    #[ORM\ManyToOne(inversedBy: 'productions')]
    private ?Animal $animal = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateProd(): ?\DateTimeInterface
    {
        return $this->dateProd;
    }

    public function setDateProd(\DateTimeInterface $dateProd): static
    {
        $this->dateProd = $dateProd;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        if (!in_array($type, [self::TYPE_LAIT, self::TYPE_OEUF, self::TYPE_VIANDE])) {
            throw new \InvalidArgumentException("Valeur invalide pour le type de production.");
        }
        $this->type = $type;
        return $this;
    }

    public function getQuantiteProd(): ?float
    {
        return $this->quantiteProd;
    }

    public function setQuantiteProd(float $quantiteProd): static
    {
        $this->quantiteProd = $quantiteProd;
        return $this;
    }

    public function getQualiteProd(): ?string
    {
        return $this->qualiteProd;
    }

    public function setQualiteProd(string $qualiteProd): static
    {
        $this->qualiteProd = $qualiteProd;
        return $this;
    }

    public function getAnimal(): ?Animal
    {
        return $this->animal;
    }

    public function setAnimal(?Animal $animal): static
    {
        $this->animal = $animal;
        return $this;
    }
}
