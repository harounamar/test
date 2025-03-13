<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    public const ETAT_SAIN = 'sain';
    public const ETAT_MALADE = 'malade';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank(message: "Le nom ne peut pas être vide.")]
    #[ORM\Column(length: 255)]
    private ?string $nom = null;


    #[ORM\Column(length: 10)]
    private ?string $etat = null;

    #[Assert\NotNull(message: "La date ne peut pas être nulle.")]
    #[Assert\Type(\DateTimeInterface::class, message: "La date doit être une date valide.")]
    #[Assert\LessThanOrEqual("today", message: "la date ne peut pas être supérieur à aujourd'hui .")]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $dateNaissance = null;

    /**
     * @var Collection<int, Production>
     */
    #[ORM\OneToMany(targetEntity: Production::class, mappedBy: 'animal', cascade: ['persist', 'remove'])]
    private Collection $productions;

    public function __construct()
    {
        $this->productions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        if (!in_array($etat, [self::ETAT_SAIN, self::ETAT_MALADE])) {
            throw new \InvalidArgumentException("Valeur invalide pour l'état de l'animal.");
        }
        $this->etat = $etat;
        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;
        return $this;
    }

    /**
     * @return Collection<int, Production>
     */
    public function getProductions(): Collection
    {
        return $this->productions;
    }

    public function addProduction(Production $production): static
    {
        if (!$this->productions->contains($production)) {
            $this->productions->add($production);
            $production->setAnimal($this); // ✅ Correction ici
        }

        return $this;
    }

    public function removeProduction(Production $production): static
    {
        if ($this->productions->removeElement($production)) {
            // set the owning side to null (unless already changed)
            if ($production->getAnimal() === $this) { // ✅ Correction ici
                $production->setAnimal(null);
            }
        }

        return $this;
    }
}
