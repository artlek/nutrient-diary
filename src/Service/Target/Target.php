<?php

namespace App\Service\Target;

use App\Entity\User;
use App\Entity\NutrientHasTarget;
use App\Entity\Nutrient;

abstract class Target
{
    # gets nutrient target for $user
    public function get(User $user)
    {
        $nutrients = $this->em->getRepository(Nutrient::class);
        $nutrientHasTarget = $this->em->getRepository(NutrientHasTarget::class)->findOneBy([
            'nutrient' => $nutrients->findOneBy(['name' => $this->nutrientName]),
            'userId' => $user->getId()
        ]);
        if(!($nutrientHasTarget)){
            return null;
        }
        return $nutrientHasTarget->getTarget();
    }
}
