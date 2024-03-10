<?php

namespace App\Service\Nutrient\AddNutrient;

use App\Service\Nutrient\AddNutrient\Chain;
use App\Entity\Nutrient;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use App\Service\ObjectNameChecker\ObjectNameChecker;
use App\Service\ObjectNameChecker\CheckNutrientNameExist;

class CheckNutrientNameExistLink extends Chain
{
    public function __construct(private RouterInterface $router, private RequestStack $requestStack, private CheckNutrientNameExist $checkNutrientNameExist)
    {

    }

    public function process(Nutrient $nutrient): void
    {
        $checker = new ObjectNameChecker($this->checkNutrientNameExist);
        if ($checker->check($nutrient)) {
            $this->requestStack->getSession()->getFlashBag()->add('negative', $nutrient->getName() . ' nutrient already exists.');
        }
        else {
            $this->nextChainElement->process($nutrient);
        }
    }
}