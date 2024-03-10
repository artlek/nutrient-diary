<?php

namespace App\Service\Nutrient;

use App\Service\Nutrient\AddNutrient\AddNutrientLink;
use App\Service\Nutrient\AddNutrient\CheckNutrientLimitLink;
use App\Service\Nutrient\AddNutrient\CheckNutrientNameExistLink;
use App\Entity\Nutrient;

class AddNutrient
{
    public function __construct(private CheckNutrientLimitLink $checkNutrientLimit, private CheckNutrientNameExistLink $checkNutrientNameExist, private AddNutrientLink $addNutrient)
    {

    }

    public function add(Nutrient $nutrient): void
    {
        $this->checkNutrientLimit->setNextChainElement($this->checkNutrientNameExist);
        $this->checkNutrientNameExist->setNextChainElement($this->addNutrient);
        $this->checkNutrientLimit->process($nutrient);
    }
}