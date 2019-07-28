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

    /**
     * Get employees information
     * @return array
     */
    public function getExport(): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = 'SELECT e.employee, t.name, e.distance, c.value, c.date
                FROM employees e
                LEFT JOIN compensation c on e.id = c.employee_id
                LEFT JOIN transport t on e.transport_id = t.id
                ORDER BY c.date ASC, e.id ASC';
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

}
