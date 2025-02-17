<?php
namespace App\Entity;

use App\Repository\PilotRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PilotRepository::class)]
class Pilot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $xws = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable:true)]
    private ?string $caption = null;

    #[ORM\Column]
    private ?int $initiative = null;

    #[ORM\Column]
    private ?int $limited = null;

    #[ORM\Column]
    private ?int $cost = null;

    #[ORM\Column]
    private ?int $loadout = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $ability = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $text = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column(length: 255)]
    private ?string $artwork = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $shipAbility = null;

    #[ORM\Column(length: 255)]
    private ?string $keywords = null;

    #[ORM\Column(length: 255)]
    private ?string $slots = null;

    // ManyToOne with Ship
    #[ORM\ManyToOne(targetEntity: Ship::class)]
    #[ORM\JoinColumn(name: "id_ship", referencedColumnName: "id")]
    private ?Ship $ship = null;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCaption(): ?string
    {
        return $this->caption;
    }

    public function setCaption(?string $caption): static
    {
        $this->caption = $caption;

        return $this;
    }

    public function getInitiative(): ?int
    {
        return $this->initiative;
    }

    public function setInitiative(int $initiative): static
    {
        $this->initiative = $initiative;

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

    public function getLoadout(): ?int
    {
        return $this->loadout;
    }

    public function setLoadout(int $loadout): static
    {
        $this->loadout = $loadout;

        return $this;
    }

    public function getAbility(): ?string
    {
        return $this->ability;
    }

    public function setAbility(?string $ability): static
    {
        $this->ability = $ability;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(?string $text): static
    {
        $this->text = $text;

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

    public function getShipAbility(): ?string
    {
        return $this->shipAbility;
    }

    public function setShipAbility(?string $shipAbility): static
    {
        $this->shipAbility = $shipAbility;

        return $this;
    }

    public function getKeywords(): ?string
    {
        return $this->keywords;
    }

    public function setKeywords(string $keywords): static
    {
        $this->keywords = $keywords;

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

    // ManyToOne to get ship
    public function getShip(): ?Ship
    {
        return $this->ship;
    }

    public function setShip(?Ship $ship): static
    {
        $this->ship = $ship;

        return $this;
    }
}
