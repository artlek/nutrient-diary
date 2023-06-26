<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Entity\User;

class CheckIfProductExist
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function check($productName, User $user) : bool
    {
        $product = $this->em->getRepository(Product::class)->findBy([
            'name' => $productName,
            'user' => $user->getId(),
            'isDeleted' => false
        ]);
        if($product){
            return true;
        }
        else {
            return false;
        }
    }
}