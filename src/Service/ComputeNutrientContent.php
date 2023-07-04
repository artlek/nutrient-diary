<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ProductHasNutrients;

class ComputeNutrientContent
{
    private ProductHasNutrients $productHasNutrients;

    public function __construct(private EntityManagerInterface $em)
    {
    }

    # calculates how much of nutrient is contained in given quantity of a product
    public function compute(int $productId, int $nutrientId, float $quantity) : float
    {
        $this->productHasNutrients = $this->em->getRepository(ProductHasNutrients::class)->findOneBy([
            'products' => $productId,
            'nutrients' => $nutrientId
        ]);
        if($this->productHasNutrients){
            return round(0.01 * $quantity * $this->productHasNutrients->getQuantity(), 2);
        }
        else{
            return 0;
        }
    }
}