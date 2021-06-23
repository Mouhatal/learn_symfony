<?php

namespace App\Repository;

use App\Entity\PriseService;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PriseService|null find($id, $lockMode = null, $lockVersion = null)
 * @method PriseService|null findOneBy(array $criteria, array $orderBy = null)
 * @method PriseService[]    findAll()
 * @method PriseService[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PriseServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PriseService::class);
    }

    // /**
    //  * @return PriseService[] Returns an array of PriseService objects
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
    public function findOneBySomeField($value): ?PriseService
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
