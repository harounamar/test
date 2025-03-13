<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Repository\CatalogueRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;  


#[ORM\Entity(repositoryClass: CatalogueRepository::class)]
class Catalogue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "La description ne peut pas être vide.")]
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[Assert\NotBlank(message: "La fournisseur ne peut pas être vide.")]
    #[ORM\Column(length: 255)]
    private ?string $fournisseur = null;

    #[Assert\NotNull(message: "La date ne peut pas être nulle.")]
    #[Assert\Type(\DateTimeInterface::class, message: "La date doit être une date valide.")]
    #[Assert\LessThanOrEqual("today", message: "la date ne peut pas être supérieur à aujourd'hui .")]
    #[Assert\GreaterThanOrEqual(
        "today - 1 year",
        message: "La date ne peut pas dépasser un an."
    )]
    #[ORM\Column(type: "date")]
    private ?\DateTimeInterface $dateAjoutCat ;

    #[ORM\ManyToMany(targetEntity: Ressources::class, inversedBy: 'catalogues')]
    #[ORM\JoinTable(name: 'catalogue_ressources')]
    private Collection $ressources;
    public function __construct()
    {
        $this->ressources = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
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
    public function getFournisseur(): ?string
    {
        return $this->fournisseur;
    }

    public function setFournisseur(string $fournisseur): self
    {
        $this->fournisseur = $fournisseur;
        return $this;
    }
    public function getDateAjoutCat(): ?\DateTimeInterface
    {
        return $this->dateAjoutCat;
    }

    public function setDateAjoutCat(\DateTimeInterface $dateAjoutCat): self
    {
        $this->dateAjoutCat = $dateAjoutCat;
        return $this;
    }
    public function getRessources(): Collection
    {
        return $this->ressources;
    }
    public function addRessource(Ressources $ressource): self
    {
        if (!$this->ressources->contains($ressource)) {
            $this->ressources->add($ressource);
            $ressource->addCatalogue($this);
        }
        return $this;
    }
    public function removeRessource(Ressources $ressource): self
    {
        if ($this->ressources->removeElement($ressource)) {
            $ressource->removeCatalogue($this);
        }
        return $this;
    }

    
}
