<?php

namespace App\Repository;

use App\Entity\HolidayApis;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HolidayApis|null find($id, $lockMode = null, $lockVersion = null)
 * @method HolidayApis|null findOneBy(array $criteria, array $orderBy = null)
 * @method HolidayApis[]    findAll()
 * @method HolidayApis[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HolidayApisRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HolidayApis::class);
    }

    // /**
    //  * @return HolidayApis[] Returns an array of HolidayApis objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HolidayApis
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
