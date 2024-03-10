<?php

namespace App\Service\Nutrient;

use App\Service\Target\GetTarget;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class SetTargetToNutrients
{
    private array $nutrients;

    public function __construct(private EntityManagerInterface $em, private GetTarget $getTarget, private Security $security)
    {
        
    }

    # sets target to each nutrient
    public function set(array $nutrients): array
    {
        $this->nutrients = $nutrients;
        foreach ($this->nutrients as $nutrient) {
            $nutrient->setTarget($this->getTarget->get($nutrient, $this->security->getUser(), new DateTime('now')));
        }
        return $this->nutrients;
    }
}