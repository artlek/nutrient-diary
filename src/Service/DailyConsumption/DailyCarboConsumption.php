<?php

namespace App\Service\DailyConsumption;

use App\Service\DailyConsumption\DailuNutrientConsumption;
use Doctrine\ORM\EntityManagerInterface;

class DailyCarboConsumption extends DailyNutrientConsumption
{
    protected $nutrientName = 'carbo';

    public function __construct(protected EntityManagerInterface $em)
    {
    }
}
