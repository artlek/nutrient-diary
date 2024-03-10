<?php

namespace App\Service\ObjectNameChecker;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Nutrient;
use App\Service\ObjectNameChecker\IObjectNameChecker;

class CheckNutrientNameExist implements IObjectNameChecker
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }

    public function check($nutrient): bool
    {
        $object = $this->em->getRepository(Nutrient::class)->findBy([
            'name' => $nutrient->getName(),
            'User' => $nutrient->getUser(),
        ]);
        return $object ? true : false;
    }
}