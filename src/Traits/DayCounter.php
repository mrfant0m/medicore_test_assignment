<?php

namespace App\Traits;

trait DayCounter
{
    /**
     * Count employee working days for selected month
     * @param int $workWeekDays
     * @param int $month
     * @param int $year
     * @return int
     */
    public function getWorkingDays($workWeekDays, $month, $year): int
    {
        $dateFrom = new \DateTime();
        $dateFrom->setDate($year, $month, 1);

        $dateTill = clone $dateFrom;
        $dateTill->modify('last day of this month');

        //day counter
        $counter = clone $dateFrom;

        $workingDays = 0;

        while ($counter <= $dateTill) {
            $dayName = $counter->format('D');
            $dayCount = $counter->format('N');;
            if (!in_array($dayName, ['Sun', 'Sat']) && $workWeekDays >= $dayCount) {
                $workingDays++;
            }
            $counter->add(new \DateInterval('P1D'));
        }
        return $workingDays;
    }

    /**
     * Get dates of first monday in month
     * @param int $month
     * @param int $year
     * @return array
     */
    public function getFirstMondayDate($month, $year): int
    {
        // count of day in week 1 for Monday
        $dayOfWeek = 1;
        // get day number in week for first day of $month
        $dayOfWeekFirstDayOfMonth = date('w', mktime(0, 0, 0, $month, 1, $year));

        if ($dayOfWeekFirstDayOfMonth <= $dayOfWeek) {
            $diference = $dayOfWeek - $dayOfWeekFirstDayOfMonth;
        } else {
            $diference = 7 - $dayOfWeekFirstDayOfMonth + $dayOfWeek;
        }

        return 1 + $diference;
    }

}