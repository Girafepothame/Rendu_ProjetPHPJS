<?php

namespace App\Entity;

use App\Repository\SquadronShipRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SquadronShipRepository::class)]
class SquadronShip
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Squadron::class, inversedBy: "ships")]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    private Squadron $squadron;

    #[ORM\ManyToOne(targetEntity: Ship::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Ship $ship;

    #[ORM\ManyToOne(targetEntity: Pilot::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Pilot $pilot;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSquadron(): ?Squadron
    {
        return $this->squadron;
    }

    public function setSquadron(?Squadron $squadron): static
    {
        $this->squadron = $squadron;

        return $this;
    }

    public function getShip(): ?Ship
    {
        return $this->ship;
    }

    public function setShip(?Ship $ship): static
    {
        $this->ship = $ship;

        return $this;
    }

    public function getPilot(): ?Pilot
    {
        return $this->pilot;
    }

    public function setPilot(?Pilot $pilot): static
    {
        $this->pilot = $pilot;

        return $this;
    }
}
