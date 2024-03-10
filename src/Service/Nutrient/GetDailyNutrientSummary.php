<?php

namespace App\Service\Nutrient;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use App\Entity\Nutrient;
use App\Service\Nutrient\CountDailyNutrientConsumption;
use DateTime;
use App\Service\Target\GetTarget;

class GetDailyNutrientSummary
{
    public function __construct(private EntityManagerInterface $em, private CountDailyNutrientConsumption $countConsumption, private GetTarget $getTarget)
    {

    }

    # returns array with nutrients daily consumptions and targets for typed date and user
    public function get(DateTime $date, User $user): array
    {
        $summary = array();
        $nutrients = $this->em->getRepository(Nutrient::class)->findBy(['User' => $user]);
        if ($nutrients){ 
            foreach ($nutrients as $nutrient) {
                $summary_row = [
                    'nutrient_name' => $nutrient->getName(),
                    'consumption' => $this->countConsumption->count($date, $user, $nutrient),
                    'target' => $this->getTarget->get($nutrient, $user, $date)
                ];
                array_push($summary, $summary_row);
            }
        }
        return $summary;
    }
}