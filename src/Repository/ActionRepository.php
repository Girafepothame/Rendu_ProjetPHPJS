<?php

namespace App\Repository;

use App\Entity\Action;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Action>
 */
class ActionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Action::class);
    }

    public function findAllAsArray(): array
    {
        return array_map(function (Action $action) {
            return [
                'id' => $action->getId(),
                'difficulty' => $action->getDifficulty(),
                'type' => $action->getType(),
                'ship' => $action->getShip() ? [
                    'id' => $action->getShip()->getId(),
                    'name' => $action->getShip()->getName(),
                ] : null,
                'linkedAction' => $action->getLinkedAction() ? [
                    'id' => $action->getLinkedAction()->getId(),
                    'type' => $action->getLinkedAction()->getType(),
                    'difficulty' => $action->getLinkedAction()->getDifficulty(),
                ] : null,
            ];
        }, $this->findAll());
    }


    //    /**
    //     * @return Action[] Returns an array of Action objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('a.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Action
    //    {
    //        return $this->createQueryBuilder('a')
    //            ->andWhere('a.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
