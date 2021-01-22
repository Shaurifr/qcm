<?php

namespace App\Repository;

use App\Entity\StillQuestion;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method StillQuestion|null find($id, $lockMode = null, $lockVersion = null)
 * @method StillQuestion|null findOneBy(array $criteria, array $orderBy = null)
 * @method StillQuestion[]    findAll()
 * @method StillQuestion[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StillQuestionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StillQuestion::class);
    }

    // /**
    //  * @return StillQuestion[] Returns an array of StillQuestion objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?StillQuestion
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
