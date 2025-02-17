<?php

namespace App\Entity;

use App\Repository\SideRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SideRepository::class)]
class Side
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $ability = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $artwork = null;

    #[ORM\Column(length: 255)]
    private ?string $slots = null;

    #[ORM\Column]
    private ?int $id_upgrade = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getAbility(): ?string
    {
        return $this->ability;
    }

    public function setAbility(string $ability): static
    {
        $this->ability = $ability;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

        return $this;
    }

    public function getArtwork(): ?string
    {
        return $this->artwork;
    }

    public function setArtwork(string $artwork): static
    {
        $this->artwork = $artwork;

        return $this;
    }

    public function getSlots(): ?string
    {
        return $this->slots;
    }

    public function setSlots(string $slots): static
    {
        $this->slots = $slots;

        return $this;
    }

    public function getIdUpgrade(): ?int
    {
        return $this->id_upgrade;
    }

    public function setIdUpgrade(int $id_upgrade): static
    {
        $this->id_upgrade = $id_upgrade;

        return $this;
    }
}
