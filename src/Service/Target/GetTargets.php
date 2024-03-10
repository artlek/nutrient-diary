<?php

namespace App\Service\Target;

use App\Entity\Nutrient;
use App\Entity\Target;
use Doctrine\ORM\EntityManagerInterface;

class GetTargets
{
    private array $targets;
    private array $array;

    public function __construct(private EntityManagerInterface $em)
    {

    }

    # returns array of daily targets for typed nutrient
    public function get(Nutrient $nutrient): array
    {
        $this->targets = $this->em->getRepository(Target::class)->findBy(
            ['nutrient' => $nutrient], 
            ['id' => 'ASC']
        );
        $this->array = array();
        for ($i = 0; $i < count($this->targets); $i++) {
            $this->array[$i] = ['date' => $this->targets[$i]->getDate()->format('Y-m-d'), 'value' => $this->targets[$i]->getValue()];
        }
        return $this->array;
    }
}