<?php

namespace App\Repository;

use App\Entity\Employees;
use App\Entity\Compensation;
use App\Entity\Transport;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class EmployeesRepository extends ServiceEntityRepository
{
    /**
     * CompensationRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Employees::class);
    }


}
