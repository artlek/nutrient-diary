<?php

namespace App\Service\ObjectDeleter;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\ObjectDeleter\IObjectDeleter;

class DiaryDeleter implements IObjectDeleter
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }

    public function delete($diary): void
    {
        $this->em->remove($diary);
        $this->em->flush();
    }
}