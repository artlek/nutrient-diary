<?php

namespace App\Service\Nutrient\AddNutrient;

use App\Entity\Nutrient;

abstract class Chain 
{
    protected $nextChainElement;
    
    public function setNextChainElement(Chain $nextChainElement)
    {
        $this->nextChainElement = $nextChainElement;
    }
    
    public abstract function process(Nutrient $nutrient): void;
}