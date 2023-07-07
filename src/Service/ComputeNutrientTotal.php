<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Nutrient;
use App\Entity\Diary;
use App\Entity\ProductHasNutrients;

class ComputeNutrientTotal
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    # calculates the sum of nutrient in products from single day ($date)
    public function compute(string $date, int $nutrientId, int $userId) : float
    {
        $nutrient = $this->em->getRepository(Nutrient::class)->findOneBy(['id' => $nutrientId]);
        $productHasNutrients = $this->em->getRepository(ProductHasNutrients::class);
        $diaries = $this->em->getRepository(Diary::class)->findBy([
            'user' => $userId,
            'date' => $date
        ]);
        if($nutrient AND $diaries){
            $total = 0;
            for($i = 0; $i < count($diaries); $i++){
                $productQuantity = $diaries[$i]->getQuantity();
                $nutrientQuantity = $productHasNutrients->findOneBy([
                    'nutrients' => $nutrientId,
                    'products' => $diaries[$i]->getProduct()->getId()
                ])->getQuantity();
                $total += $productQuantity * $nutrientQuantity;
            }
            return round($total/100, 2);
        }
        else{
            return 0;
        }
    }
}