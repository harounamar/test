<?php

namespace App\Entity;

use App\Repository\RessourcesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Enum\RessourceType;
use Symfony\Component\Validator\Constraints as Assert;  


#[ORM\Entity(repositoryClass: RessourcesRepository::class)]
class Ressources
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[Assert\NotBlank(message: "Le type de la ressource ne peut pas être vide.")]
    #[ORM\Column(type: 'string', length: 20, enumType: RessourceType::class)]
    private RessourceType $type;

    #[Assert\NotNull(message: "La quantité ne peut pas être nulle.")]
    #[Assert\PositiveOrZero(message: "La quantité ne peut pas être négative.")]
    #[ORM\Column]
    private ?int $quantiteDisponible = null;


    #[Assert\NotNull(message: "La date ne peut pas être nulle.")]
    #[Assert\Type(\DateTimeInterface::class, message: "La date doit être une date valide.")]
    #[Assert\LessThanOrEqual("today", message: "la date ne peut pas être supérieur à aujourd'hui .")]
    #[Assert\GreaterThanOrEqual(
        "today - 1 year",
        message: "La date ne doit pas dépasser un an."
    )]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateAjout = null;

    /**
     * @var Collection<int, Catalogue>
     */
    #[ORM\ManyToMany(targetEntity: Catalogue::class, mappedBy: 'ressources')]
    private Collection $catalogues;

    public function __construct()
    {
        $this->catalogues = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getType(): RessourceType
{
    return RessourceType::from($this->getTypeAsString());
}

public function setType(RessourceType $type): self
{
    $this->type =  $type;
    return $this;
}

public function getTypeAsString(): string
{
    return $this->type->value;
}
    public function getQuantiteDisponible(): ?int
    {
        return $this->quantiteDisponible;
    }

    public function setQuantiteDisponible(int $quantiteDisponible): static
    {
        $this->quantiteDisponible = $quantiteDisponible;

        return $this;
    }

    public function getDateAjout(): ?\DateTimeInterface
    {
        return $this->dateAjout;
    }

    public function setDateAjout(\DateTimeInterface $dateAjout): static
    {
        $this->dateAjout = $dateAjout;

        return $this;
    }

    /**
     * @return Collection<int, Catalogue>
     */
    public function getCatalogues(): Collection
    {
        return $this->catalogues;
    }

    public function addCatalogue(Catalogue $catalogue): static
    {
        if (!$this->catalogues->contains($catalogue)) {
            $this->catalogues->add($catalogue);
            $catalogue->addRessource($this);
        }

        return $this;
    }

    public function removeCatalogue(Catalogue $catalogue): static
    {
        if ($this->catalogues->removeElement($catalogue)) {
            $catalogue->removeRessource($this);
        }

        return $this;
    }
}
