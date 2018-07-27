<?php

namespace App\Helper;

class DateTimeHelper
{
    public static function getDates($startDate, $endDate, $interval)
    {
        $dates = [];
        $period = new \DatePeriod(
            new \DateTime($startDate),
            new \DateInterval($interval),
            new \DateTime($endDate)
        );

        foreach ($period as $key => $value) {
            array_push($dates, $value->format('d-m-Y'));
        }
        array_push($dates, $endDate);

        return $dates;
    }
}
