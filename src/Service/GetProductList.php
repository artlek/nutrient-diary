<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;

class GetProductList
{
    public function __construct(private EntityManagerInterface $em)
    {
    }

    public function getProductList($userId)
    {
        $products = $this->em->getRepository(Product::class)->findBy([
            'isDeleted' => false,
            'user' => $userId
        ]);
        for($i = 0; $i < count($products); $i++){
            $products[$i]
                ->setFat($products[$i]->getHasNutrients()->get(0)->getQuantity())
                ->setCarbo($products[$i]->getHasNutrients()->get(1)->getQuantity())
                ->setProtein($products[$i]->getHasNutrients()->get(2)->getQuantity())
                ->setKcal($products[$i]->getHasNutrients()->get(3)->getQuantity())
            ;
        }
        return $products;
    }
}