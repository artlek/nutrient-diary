<?php

namespace App\Service\Target;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\Target\Target;

class KcalTarget extends Target
{
    protected $nutrientName = 'kcal';

    public function __construct(protected EntityManagerInterface $em)
    {
    }
}
