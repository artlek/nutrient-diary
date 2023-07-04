<?php

namespace App\Service;

use DateTime;

class ValidateDate
{
    // checks if $date has valid date format
    public function validate($date, $format = 'Y-m-d') : bool
    {
        $d = DateTime::createFromFormat($format, $date);
        if($d AND $d->format($format) === $date)
        {
            return true;
        }
        else{
            return false;
        }
    }
}