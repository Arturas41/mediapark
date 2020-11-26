<?php

namespace App\Repository;

use App\Entity\HolidayApi;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HolidayApi|null find($id, $lockMode = null, $lockVersion = null)
 * @method HolidayApi|null findOneBy(array $criteria, array $orderBy = null)
 * @method HolidayApi[]    findAll()
 * @method HolidayApi[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HolidayApiRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HolidayApi::class);
    }

}
