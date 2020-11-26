<?php

namespace App\Repository;

use App\Entity\SupportedCountry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SupportedCountry|null find($id, $lockMode = null, $lockVersion = null)
 * @method SupportedCountry|null findOneBy(array $criteria, array $orderBy = null)
 * @method SupportedCountry[]    findAll()
 * @method SupportedCountry[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupportedCountryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SupportedCountry::class);
    }
}
