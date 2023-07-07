<?php

namespace App\Service\DailyConsumption;

use App\Service\DailyConsumption\DailuNutrientConsumption;
use Doctrine\ORM\EntityManagerInterface;

class DailyFatConsumption extends DailyNutrientConsumption
{
    protected $nutrientName = 'fat';

    public function __construct(protected EntityManagerInterface $em)
    {
    }
}
