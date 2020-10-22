<?php

namespace App\Repository;

use App\Entity\WorldMap;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method WorldMap|null find($id, $lockMode = null, $lockVersion = null)
 * @method WorldMap|null findOneBy(array $criteria, array $orderBy = null)
 * @method WorldMap[]    findAll()
 * @method WorldMap[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class WorldMapRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WorldMap::class);
    }

    // /**
    //  * @return WorldMap[] Returns an array of WorldMap objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('w.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?WorldMap
    {
        return $this->createQueryBuilder('w')
            ->andWhere('w.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
