<?php

namespace App\Entity;

use App\Repository\ShipRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ShipRepository::class)]
class Ship
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $xws = null;

    #[ORM\Column(length: 255)]
    private ?string $size = null;

    #[ORM\Column(length: 255)]
    private ?string $icon = null;

    #[ORM\Column(length: 255)]
    private ?string $maneuvers = null;
    
    #[ORM\Column(length: 255)]
    private ?string $dialCode = null;

    // Relation ManyToOne avec Faction
    #[ORM\ManyToOne(targetEntity: Faction::class)]
    #[ORM\JoinColumn(name: "id_faction", referencedColumnName: "id")]
    private ?Faction $faction = null;

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

    public function getXws(): ?string
    {
        return $this->xws;
    }

    public function setXws(string $xws): static
    {
        $this->xws = $xws;
        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(string $size): static
    {
        $this->size = $size;
        return $this;
    }

    public function getIcon(): ?string
    {
        return $this->icon;
    }

    public function setIcon(string $icon): static
    {
        $this->icon = $icon;
        return $this;
    }

    public function getManeuvers(): ?string
    {
        return $this->maneuvers;
    }

    public function setManeuvers(string $maneuvers): static
    {
        $this->maneuvers = $maneuvers;
        return $this;
    }

    public function getDialCode(): ?string
    {
        return $this->dialCode;
    }

    public function setDialCode(string $dialCode): static
    {
        $this->dialCode = $dialCode;
        return $this;
    }

    // Getters & setters for ManyToOne
    public function getFaction(): ?Faction
    {
        return $this->faction;
    }

    public function setFaction(?Faction $faction): static
    {
        $this->faction = $faction;
        return $this;
    }
}

