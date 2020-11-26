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

}
