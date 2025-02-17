<?php

namespace App\Repository;

use App\Entity\Pilot;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Pilot>
 */
class PilotRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pilot::class);
    }

    public function findAllAsArray(): array
    {
        return array_map(function (Pilot $pilot) {
            return [
                'id' => $pilot->getId(),
                'xws' => $pilot->getXws(),
                'name' => $pilot->getName(),
                'caption' => $pilot->getCaption(),
                'initiative' => $pilot->getInitiative(),
                'limited' => $pilot->getLimited(),
                'cost' => $pilot->getCost(),
                'loadout' => $pilot->getLoadout(),
                'ability' => $pilot->getAbility(),
                'text' => $pilot->getText(),
                'image' => $pilot->getImage(),
                'artwork' => $pilot->getArtwork(),
                'shipAbility' => $pilot->getShipAbility(),
                'keywords' => $pilot->getKeywords(),
                'slots' => $pilot->getSlots(),
                'ship' => $pilot->getShip() ? [
                    'id' => $pilot->getShip()->getId(),
                    'name' => $pilot->getShip()->getName(),
                ] : null,
            ];
        }, $this->findAll());
    }


    //    /**
    //     * @return Pilot[] Returns an array of Pilot objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Pilot
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
