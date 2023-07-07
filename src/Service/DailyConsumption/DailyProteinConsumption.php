<?php

namespace App\Service\DailyConsumption;

use App\Service\DailyConsumption\DailuNutrientConsumption;
use Doctrine\ORM\EntityManagerInterface;

class DailyProteinConsumption extends DailyNutrientConsumption
{
    protected $nutrientName = 'protein';

    public function __construct(protected EntityManagerInterface $em)
    {
    }
}
