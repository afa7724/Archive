<?php

namespace App\Repository;

use App\Entity\ArchiveLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ArchiveLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArchiveLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArchiveLike[]    findAll()
 * @method ArchiveLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArchiveLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ArchiveLike::class);
    }

    // /**
    //  * @return ArchiveLike[] Returns an array of ArchiveLike objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ArchiveLike
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
