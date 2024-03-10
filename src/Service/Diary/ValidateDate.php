<?php

namespace App\Service\Diary;

use DateTime;

class ValidateDate
{
    private string $format = 'Y-m-d';

    // checks if date has valid date format
    public function validate($date): bool
    {
        $d = DateTime::createFromFormat($this->format, $date);
        if ($d AND $d->format($this->format) === $date) {
            return true;
        }
        else {
            return false;
        }
    }
}