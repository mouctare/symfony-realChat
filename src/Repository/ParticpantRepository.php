<?php

namespace App\Repository;

use App\Entity\Particpant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Particpant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Particpant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Particpant[]    findAll()
 * @method Particpant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticpantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Particpant::class);
    }

    // /**
    //  * @return Particpant[] Returns an array of Particpant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Particpant
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
