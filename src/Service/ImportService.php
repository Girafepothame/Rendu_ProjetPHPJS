<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\{Action, Bonus, Charge, Dial, Faction, Force, Loadout, Maneuver, Pilot, Restriction, Ship, Side, Stat, Upgrade, UpgradeLoadout};

class ImportService
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function importFactions(array $factionsData)
    {
        foreach ($factionsData as $factionData) {
            // Check if the faction already exists in the database
            $faction = $this->entityManager->getRepository(Faction::class)->findOneBy(['xws' => $factionData['xws']]);

            if (!$faction) {
                // Create a new faction entity if it does not exist
                $faction = new Faction();
                $faction->setName($factionData['name']);
                $faction->setXws($factionData['xws']);
                $faction->setIcon($factionData['icon']);
    
                $this->entityManager->persist($faction);
            }
        }
        // Save all changes to the database
        $this->entityManager->flush();
    }

    public function importShipsAndPilots(array $shipsData): void
    {
        // Find the faction associated with the ship data
        $faction = $this->entityManager->getRepository(Faction::class)->findOneBy(['xws' => $shipsData['faction']]);

        if (!$faction) {
            throw new \Exception("Faction not found for XWS: " . $shipsData['faction']);
        }

        // Check if a ship with the same xws and faction already exists
        $ship = $this->entityManager->getRepository(Ship::class)->findOneBy([
            'xws' => $shipsData['xws'],
            'faction' => $faction
        ]);

        // If the ship does not exist, create a new ship entity
        if (!$ship) {
            $ship = new Ship();
            $ship->setName($shipsData['name']);
            $ship->setXws($shipsData['xws']);
            $ship->setSize($shipsData['size']);
            $ship->setIcon($shipsData['icon'] ?? "");
            $ship->setManeuvers(implode(",", $shipsData['dial'] ?? []));
            $ship->setDialCode($shipsData['dialCodes'][0]);
            $ship->setFaction($faction);

            $this->entityManager->persist($ship);
            $this->entityManager->flush(); // Flush here to get the ID before adding its relations
        }

        // Import associated data
        $this->importStats($shipsData['stats'], $ship);
        $this->importActions($shipsData['actions'], $ship);

        foreach ($shipsData['pilots'] as $pilotData) {
            // Check if the pilot already exists with the same XWS and ship
            $pilot = $this->entityManager->getRepository(Pilot::class)->findOneBy([
                'xws' => $pilotData['xws'],
                'ship' => $ship
            ]);

            if (!$pilot) {
                // Create a new pilot entity if it does not exist
                $pilot = new Pilot();
                $pilot->setName($pilotData['name']);
                $pilot->setXws($pilotData['xws']);
                $pilot->setCaption($pilotData['caption'] ?? null);
                $pilot->setInitiative($pilotData['initiative']);
                $pilot->setLimited($pilotData['limited']);
                $pilot->setCost($pilotData['cost']);
                $pilot->setLoadout($pilotData['loadout'] ?? 0);
                $pilot->setAbility($pilotData['ability'] ?? null);
                $pilot->setText($pilotData['text'] ?? null);
                $pilot->setImage($pilotData['image'] ?? "");
                $pilot->setArtwork($pilotData['artwork']);
                $pilot->setShipAbility(isset($pilotData['shipAbility']) ? $pilotData['shipAbility']['name'] . ": " . $pilotData['shipAbility']['text'] : null);
                $pilot->setKeywords(implode(",", $pilotData['keywords'] ?? []));
                $pilot->setSlots(implode(",", $pilotData['slots'] ?? []));

                $pilot->setShip($ship);

                $this->entityManager->persist($pilot);
            }
        }

        // Save all changes to the database
        $this->entityManager->flush();
    }

    public function importStats(array $stats, Ship $ship): void
    {
        foreach ($stats as $statData) {
            // Check if the stat already exists for the ship
            $existingStat = $this->entityManager->getRepository(Stat::class)->findOneBy([
                'type' => $statData['type'],
                'value' => $statData['value'],
                'ship' => $ship
            ]);

            if (!$existingStat) {
                // Create a new stat entity if it does not exist
                $stat = new Stat();
                $stat->setArc($statData['arc'] ?? null);
                $stat->setType($statData['type']);
                $stat->setValue($statData['value']);
                $stat->setRecovers($statData['recovers'] ?? null);
                $stat->setShip($ship);
    
                $this->entityManager->persist($stat);
            }
        }
    }

    public function importActions(array $actions, Ship $ship): void
    {
        foreach ($actions as $actionData) {
            // Check if the action already exists for the ship
            $existingAction = $this->entityManager->getRepository(Action::class)->findOneBy([
                'type' => $actionData['type'],
                'difficulty' => $actionData['difficulty'],
                'ship' => $ship
            ]);

            if (!$existingAction || isset($actionData["linked"])) {
                // Create a new action entity if it does not exist or if it has a linked action
                $action = new Action();
                $action->setDifficulty($actionData['difficulty']);
                $action->setType($actionData['type']);
                $action->setShip($ship);
    
                if (isset($actionData['linked'])) {
                    // Create a new linked action entity
                    $linkedAction = new Action();
                    $linkedAction->setDifficulty($actionData['linked']['difficulty']);
                    $linkedAction->setType($actionData['linked']['type']);
                    $linkedAction->setShip($ship);
                    
                    $this->entityManager->persist($linkedAction);
                    
                    $action->setLinkedAction($linkedAction);
                }
    
                $this->entityManager->persist($action);
            }
        }
    }

    // TODO: Import Upgrades, Loadouts, and other entities
}
