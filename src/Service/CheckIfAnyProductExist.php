<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Entity\User;

class CheckIfAnyProductExist
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function check(User $user) : bool
    {
        $products = $this->em->getRepository(Product::class)->findBy([
            'user' => $user->getId(),
            'isDeleted' => false
        ]);
        if($products){
            return true;
        }
        else {
            return false;
        }
    }
}