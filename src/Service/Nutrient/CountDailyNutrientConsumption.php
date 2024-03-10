<?php

namespace App\Service\Nutrient;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Diary;
use App\Entity\Nutrient;
use DateTime;

class CountDailyNutrientConsumption
{
    private float $consumption;

    # count daily user consumption for typed nutrient
    public function __construct(private EntityManagerInterface $em)
    {

    }

    public function count(DateTime $date, User $user, Nutrient $nutrient): float
    {
        $productsInDiary = $this->em->getRepository(Diary::class)->findBy(['user' => $user, 'date' => $date]);
        if (!$productsInDiary OR !$user) {
            return 0;
        }
        $this->consumption = 0;
        foreach ($productsInDiary as $diary) {
            foreach ($diary->getProduct()->getProductHasNutrients()->getValues() as $collection) {
                if ($collection->getNutrient()->getId() == $nutrient->getId()) {
                    $this->consumption += round($collection->getContent() * $diary->getQuantity() / 100, 2);
                }
            }
        }
        return $this->consumption;
    }
}