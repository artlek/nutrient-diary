<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class SaveToDatabase
{
    public function __construct(private EntityManagerInterface $em)
    {

    }

    public function save($object) : void
    {
        $this->em->persist($object);
        $this->em->flush();
    }
}