<?php

namespace App\Entity;

use App\Repository\RestrictionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestrictionRepository::class)]
class Restriction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $value = null;

    #[ORM\Column]
    private ?int $id_upgrade = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

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
