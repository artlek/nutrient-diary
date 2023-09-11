<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Nutrient;
use App\Entity\Diary;

class SetNutrientsToDiary
{
    public function __construct(private EntityManagerInterface $em, private ComputeNutrientContent $content)
    {
    }

    # sets nutrient content to single product of diary (it's necessary to get product list in diary)
    public function set(array $diaries) : array
    {
        $nutrients = $this->em->getRepository(Nutrient::class);
        for($i = 0; $i < count($diaries); $i++){
            $diaries[$i]->setNutrientContent([
                'fat' => $this->content->compute($diaries[$i]->getProduct()->getId(), $nutrients->findOneBy(['name' => 'fat'])->getId(), $diaries[$i]->getQuantity()),
                'carbo' => $this->content->compute($diaries[$i]->getProduct()->getId(), $nutrients->findOneBy(['name' => 'carbo'])->getId(), $diaries[$i]->getQuantity()),
                'protein' => $this->content->compute($diaries[$i]->getProduct()->getId(), $nutrients->findOneBy(['name' => 'protein'])->getId(), $diaries[$i]->getQuantity()),
                'kcal' => $this->content->compute($diaries[$i]->getProduct()->getId(), $nutrients->findOneBy(['name' => 'kcal'])->getId(), $diaries[$i]->getQuantity())
            ]);
        }
        return $diaries;
    }
}