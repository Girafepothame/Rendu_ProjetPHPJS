<?php

namespace App\Repository;

use App\Entity\Stat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stat>
 */
class StatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stat::class);
    }

    public function findAllAsArray(): array
    {
        return array_map(function (Stat $stat) {
            return [
                'id' => $stat->getId(),
                'arc' => $stat->getArc(),
                'type' => $stat->getType(),
                'value' => $stat->getValue(),
                'recovers' => $stat->getRecovers(),
                'ship' => $stat->getShip() ? [
                    'id' => $stat->getShip()->getId(),
                    'name' => $stat->getShip()->getName(),
                ] : null,
            ];
        }, $this->findAll());
    }


    //    /**
    //     * @return Stat[] Returns an array of Stat objects
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

    //    public function findOneBySomeField($value): ?Stat
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
