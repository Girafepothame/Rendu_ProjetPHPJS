<?php

namespace App\Repository;

use App\Entity\Faction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Faction>
 */
class FactionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Faction::class);
    }

    public function findAllAsArray(): array
    {
        return array_map(function (Faction $faction) {
            return [
                'id' => $faction->getId(),
                'name' => $faction->getName(),
                'xws' => $faction->getXws(),
                'icon' => $faction->getIcon(),
            ];
        }, $this->findAll());
    }


    //    /**
    //     * @return Faction[] Returns an array of Faction objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('f.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Faction
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
