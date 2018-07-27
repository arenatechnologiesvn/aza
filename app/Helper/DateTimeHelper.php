<?php

namespace App\Helper;

class DateTimeHelper
{
    public static function getListDateTime($startDate, $endDate, $interval, $format)
    {
        $dates = [];
        $period = new \DatePeriod(
            new \DateTime($startDate),
            new \DateInterval($interval),
            new \DateTime($endDate)
        );

        foreach ($period as $key => $value) {
            array_push($dates, $value->format($format));
        }
        array_push($dates, $endDate);

        return $dates;
    }
}
