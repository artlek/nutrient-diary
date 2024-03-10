<?php

namespace App\Service\ObjectAdder;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\ObjectAdder\IObjectAdder;
use App\Entity\Target;
use Symfony\Bundle\SecurityBundle\Security;
use Datetime;

class AddNutrient implements IObjectAdder
{
    public function __construct(private EntityManagerInterface $em, private Security $security)
    {
        
    }

    public function add($nutrient): bool
    {
        $target = new Target;
        $target
            ->setUser($this->security->getUser())
            ->setNutrient($nutrient)
            ->setValue(round($nutrient->getTarget(), 2))
            ->setDate(new DateTime('now'))
            ;
        $this->em->persist($target);
        $this->em->persist($nutrient);
        $this->em->flush();
        return true;
    }
}