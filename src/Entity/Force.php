<?php

namespace App\Entity;

use App\Repository\ForceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForceRepository::class)]
#[ORM\Table(name: '`force`')]
class Force
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $value = null;

    #[ORM\Column(nullable: true)]
    private ?int $recovers = null;

    #[ORM\Column(length: 255)]
    private ?string $side = null;

    #[ORM\Column]
    private ?int $id_pilot = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function getRecovers(): ?int
    {
        return $this->recovers;
    }

    public function setRecovers(?int $recovers): static
    {
        $this->recovers = $recovers;

        return $this;
    }

    public function getSide(): ?string
    {
        return $this->side;
    }

    public function setSide(string $side): static
    {
        $this->side = $side;

        return $this;
    }

    public function getIdPilot(): ?int
    {
        return $this->id_pilot;
    }

    public function setIdPilot(int $id_pilot): static
    {
        $this->id_pilot = $id_pilot;

        return $this;
    }
}
