<?php


namespace App\Service;

use App\Entity\Compensation;
use App\Entity\Employees;
use App\Traits\DayCounter;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Component\Validator\Constraints\Date;


class CalculationService
{
    use DayCounter;

    /**
     * CalculationService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->compensation = $entityManager->getRepository(Compensation::class);
    }

    /**
     * Make employee calculation
     * @return bool
     */
    public function employeeCalculation(Employees $employee)
    {
        $year = date('Y');

        //if employee working 3.25 days per week, should be 4 times travel to the office
        $weekWorkingDays = intval(ceil($employee->getWorkdays()));

        for ($month = 1; $month <= 12; $month++) {
            $paymentMonth = $month + 1;
            $paymentDay = $this->getFirstMondayDate($paymentMonth, $year);
            $paymentDate = date('Y-m-d', mktime(0, 0, 0, $paymentMonth, $paymentDay, $year));
            $workingDays = $this->getWorkingDays($weekWorkingDays, $month, $year);
            $value = $this->process($employee, $workingDays);

            $compensation = new Compensation();
            $compensation->setDate(new \DateTime($paymentDate));
            $compensation->setEmployee($employee);
            $compensation->setValue($value);
            $this->compensation->save($compensation);
        }
    }

    /**
     * Make calculation
     * @return int
     */
    private function process(Employees $employee, $days):float
    {
        $rate = $employee->getTransport()->getCompensation();
        $distance = $employee->getDistance();
        // distance two way
        $compensation = $distance * 2 * $rate * $days;

        return $compensation;
    }

}