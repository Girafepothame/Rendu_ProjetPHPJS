<?php

namespace App\Entity;

use App\Repository\UpgradeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UpgradeRepository::class)]
class Upgrade
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $xws = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $limited = null;

    #[ORM\Column]
    private ?int $cost = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
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

    public function getLimited(): ?int
    {
        return $this->limited;
    }

    public function setLimited(int $limited): static
    {
        $this->limited = $limited;

        return $this;
    }

    public function getCost(): ?int
    {
        return $this->cost;
    }

    public function setCost(int $cost): static
    {
        $this->cost = $cost;

        return $this;
    }
}
