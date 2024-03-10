<?php

namespace App\Service\Nutrient;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Nutrient;
use App\Entity\User;

class NutrientLimit
{
    public function __construct(private $nutrientLimit, private EntityManagerInterface $em)
    {

    }

    # returns true if user can add a nutrient, returns false if nutrient limit is exceeded.
    public function check(User $user): bool
    {
        $userNutrients = count($this->em->getRepository(Nutrient::class)->findBy(['User' => $user]));
        if ($this->nutrientLimit <= $userNutrients) {
            return false;
        }
        else {
            return true;
        }
    }

    public function get(): array
    {
        return $this->nutrientLimit;
    }
}