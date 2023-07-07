<?php

namespace App\Service\Target;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\Target\Target;

class FatTarget extends Target
{
    protected $nutrientName = 'fat';

    public function __construct(protected EntityManagerInterface $em)
    {
    }
}
