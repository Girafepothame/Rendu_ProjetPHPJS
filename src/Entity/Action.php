<?php

namespace App\Entity;

use App\Repository\ActionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActionRepository::class)]
class Action
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $difficulty = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\ManyToOne(targetEntity: Ship::class)]
    #[ORM\JoinColumn(name: "id_ship", referencedColumnName: "id", nullable: false)]
    private ?Ship $ship = null;

    // auto-ref relation : Action linked to another Action
    #[ORM\ManyToOne(targetEntity: Action::class)]
    #[ORM\JoinColumn(name: "id_linked", referencedColumnName: "id", nullable: true)]
    private ?Action $linkedAction = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDifficulty(): ?string
    {
        return $this->difficulty;
    }

    public function setDifficulty(string $difficulty): static
    {
        $this->difficulty = $difficulty;

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

    public function getShip(): ?Ship
    {
        return $this->ship;
    }

    public function setShip(Ship $ship): static
    {
        $this->ship = $ship;

        return $this;
    }

    // Getter and Setter for Linked Action
    public function getLinkedAction(): ?Action
    {
        return $this->linkedAction;
    }

    public function setLinkedAction(?Action $linkedAction): static
    {
        $this->linkedAction = $linkedAction;

        return $this;
    }
}
