<?php

namespace App\Service\ObjectDeleter;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ProductHasNutrients;
use App\Service\ObjectDeleter\IObjectDeleter;

class NutrientDeleter implements IObjectDeleter
{
    private array $product_has_nutrients;

    public function __construct(private EntityManagerInterface $em)
    {

    }

    public function delete($nutrient): void
    {
        $this->product_has_nutrients = $this->em->getRepository(ProductHasNutrients::class)->findBy(['nutrient' => $nutrient]);
        
        for ($i = 0; $i < count($this->product_has_nutrients); $i++) {
            $this->em->remove($this->product_has_nutrients[$i]);
        }
        $this->em->remove($nutrient);
        $this->em->flush();
    }
}