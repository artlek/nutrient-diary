<?php

namespace App\Service\Nutrient\AddNutrient;

use App\Service\Nutrient\AddNutrient\Chain;
use App\Entity\Nutrient;
use App\Service\Nutrient\NutrientLimit;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;

class CheckNutrientLimitLink extends Chain
{
    public function __construct(private NutrientLimit $nutrientLimit, private Security $security, private RouterInterface $router, private RequestStack $requestStack)
    {

    }

    public function process(Nutrient $nutrient): void
    {
        if (!$this->nutrientLimit->check($this->security->getUser())) {
            $this->requestStack->getSession()->getFlashBag()->add('negative', 'The nutrient limit has been exceeded. Maximum number of nutrients: ' . $this->nutrientLimit->get() . ' .');
        }
        else {
            $this->nextChainElement->process($nutrient);
        }
    }
}