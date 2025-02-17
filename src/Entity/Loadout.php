<?php

namespace App\Entity;

use App\Repository\LoadoutRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoadoutRepository::class)]
class Loadout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $max = null;

    #[ORM\Column]
    private ?int $total = null;

    #[ORM\Column]
    private ?int $id_pilot = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMax(): ?int
    {
        return $this->max;
    }

    public function setMax(int $max): static
    {
        $this->max = $max;

        return $this;
    }

    public function getTotal(): ?int
    {
        return $this->total;
    }

    public function setTotal(int $total): static
    {
        $this->total = $total;

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
