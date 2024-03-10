<?php

namespace App\Service\ObjectDeleter;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\ObjectDeleter\IObjectDeleter;

class ProductDeleter implements IObjectDeleter
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }

    public function delete($product): void
    {
        $product->setIsDeleted(true);
        $this->em->persist($product);
        $this->em->flush();
    }
}