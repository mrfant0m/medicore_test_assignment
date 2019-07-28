<?php

namespace App\Repository;

use App\Entity\Compensation;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

class CompensationRepository extends ServiceEntityRepository
{
    /**
     * @var Entity Manager
     */
    protected $entityManager;

    /**
     * CompensationRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Compensation::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function save(Compensation $compensation)
    {
        $compensationEntity = $this->findOneBy(['date' => $compensation->getDate(), 'employee' => $compensation->getEmployee()]);

        if ($compensationEntity) {
            $compensationEntity->setValue($compensation->getValue());
            $this->entityManager->persist($compensationEntity);
        } else {
            $this->entityManager->persist($compensation);
        }
        $this->entityManager->flush();
    }

}