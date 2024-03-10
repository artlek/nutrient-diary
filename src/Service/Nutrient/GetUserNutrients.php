<?php

namespace App\Service\Nutrient;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Nutrient;
use Symfony\Bundle\SecurityBundle\Security;

class GetUserNutrients
{
    private $nutrients;

    public function __construct(private EntityManagerInterface $em, private Security $security)
    {
        $this->nutrients = $em->getRepository(Nutrient::class)->findBy([
            'User' => $this->security->getUser()
            ]);
    }

    public function get(): array
    {
        return $this->nutrients;
    }
}