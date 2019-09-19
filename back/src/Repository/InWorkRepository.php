<?php

namespace App\Repository;

use App\Entity\InWork;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method InWork|null find($id, $lockMode = null, $lockVersion = null)
 * @method InWork|null findOneBy(array $criteria, array $orderBy = null)
 * @method InWork[]    findAll()
 * @method InWork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InWorkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InWork::class);
    }


    // /**
    //  * @return InWork[] Returns an array of InWork objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?InWork
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
