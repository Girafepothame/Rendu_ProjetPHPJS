<?php

namespace App\Entity;

use App\Repository\UpgradeLoadoutRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UpgradeLoadoutRepository::class)]
class UpgradeLoadout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_upgrade = null;

    #[ORM\Column]
    private ?int $id_loadout = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdLoadout(): ?int
    {
        return $this->id_loadout;
    }

    public function setIdLoadout(int $id_loadout): static
    {
        $this->id_loadout = $id_loadout;

        return $this;
    }
}
