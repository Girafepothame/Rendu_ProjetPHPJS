<?php

namespace App\Entity;

use App\Repository\ChargeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChargeRepository::class)]
class Charge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $value = null;

    #[ORM\Column]
    private ?int $recovers = null;

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

    public function setRecovers(int $recovers): static
    {
        $this->recovers = $recovers;

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
