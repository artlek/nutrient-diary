<?php

namespace App\Service\DailyConsumption;

use App\Service\DailyConsumption\DailuNutrientConsumption;
use Doctrine\ORM\EntityManagerInterface;

class DailyKcalConsumption extends DailyNutrientConsumption
{
    protected $nutrientName = 'kcal';

    public function __construct(protected EntityManagerInterface $em)
    {
    }
}
