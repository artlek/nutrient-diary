<?php

namespace App\Service\Target;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\Target\Target;

class ProteinTarget extends Target
{
    protected $nutrientName = 'protein';

    public function __construct(protected EntityManagerInterface $em)
    {
    }
}
