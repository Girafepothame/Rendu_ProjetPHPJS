<?php

namespace App\Repository;

use App\Entity\Ship;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Ship>
 */
class ShipRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ship::class);
    }

    public function findAllAsArray(): array
    {
        return array_map(function (Ship $ship) {
            return [
                'id' => $ship->getId(),
                'name' => $ship->getName(),
                'xws' => $ship->getXws(),
                'size' => $ship->getSize(),
                'icon' => $ship->getIcon(),
                'dialCode' => $ship->getDialCode(),
                'maneuvers' => $ship->getManeuvers(),
                'faction' => $ship->getFaction() ? [
                    'id' => $ship->getFaction()->getId(),
                    'name' => $ship->getFaction()->getName(),
                ] : null,
            ];
        }, $this->findAll());
    }


    //    /**
    //     * @return Ship[] Returns an array of Ship objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Ship
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
