<?php

namespace App\Service\DailyConsumption;

use App\Entity\Nutrient;
use App\Entity\User;
use App\Entity\Diary;
use App\Entity\ProductHasNutrients;

abstract class DailyNutrientConsumption
{
    # computes daily nutrient consumption for $user and $date
    public function compute(string $date, User $user) : float
    {
        $nutrient = $this->em->getRepository(Nutrient::class)->findOneBy(['name' => $this->nutrientName]);
        $productHasNutrients = $this->em->getRepository(ProductHasNutrients::class);
        $diaries = $this->em->getRepository(Diary::class)->findBy([
            'user' => $user->getId(),
            'date' => $date
        ]);
        if($nutrient AND $diaries){
            $total = 0;
            for($i = 0; $i < count($diaries); $i++){
                $productQuantity = $diaries[$i]->getQuantity();
                $nutrientQuantity = $productHasNutrients->findOneBy([
                    'nutrients' => $nutrient->getId(),
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
