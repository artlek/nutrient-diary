<?php

namespace App\Service\Target;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\Target\Target;

class CarboTarget extends Target
{
    protected $nutrientName = 'carbo';

    public function __construct(protected EntityManagerInterface $em)
    {
    }
}
