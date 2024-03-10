<?php

namespace App\Service\Nutrient\AddNutrient;

use App\Service\Nutrient\AddNutrient\Chain;
use App\Entity\Nutrient;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use App\Service\ObjectAdder\ObjectAdder;
use App\Service\ObjectAdder\AddNutrient;

class AddNutrientLink extends Chain
{
    public function __construct(private RouterInterface $router, private RequestStack $requestStack, private AddNutrient $addNutrient)
    {

    }

    public function process(Nutrient $nutrient): void
    {
        $adder = new ObjectAdder($this->addNutrient);
        if ($adder->add($nutrient)) {
            $this->requestStack->getSession()->getFlashBag()->add('positive', $nutrient->getName() . ' nutrient has been added.');
        }
    }
}