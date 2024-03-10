<?php

namespace App\Service\Target;

use App\Entity\User;
use App\Entity\Nutrient;
use App\Entity\Target;
use Doctrine\ORM\EntityManagerInterface;
use Datetime;

class GetTarget
{
    private array $targets;

    public function __construct(private EntityManagerInterface $em)
    {

    }

    # returns daily target for typed nutrient, user and date
    public function get(Nutrient $nutrient, User $user, Datetime $date): float
    {
        $this->targets = $this->em->getRepository(Target::class)->findBy(
            ['User' => $user, 'nutrient' => $nutrient], 
            ['id' => 'ASC']
        );
        $target = 0;
        if ($this->targets) {
            for ($i = 0; $i < count($this->targets); $i++) {
                if ($date >= $this->targets[$i]->getDate()) {
                    $target = $this->targets[$i];
                }
            }
            if ($target === 0) {
                return 0;
            }
            return $target->getValue();
        }
        return 0;
    }
}