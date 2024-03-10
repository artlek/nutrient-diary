<?php

namespace App\Service\ObjectNameChecker;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Service\ObjectNameChecker\IObjectNameChecker;

class CheckProductNameExist implements IObjectNameChecker
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }

    public function check($product): bool
    {
        $object = $this->em->getRepository(Product::class)->findBy([
            'name' => $product->getName(),
            'User' => $product->getUser(),
            'isDeleted' => false,
        ]);
        return $object ? true : false;
    }
}