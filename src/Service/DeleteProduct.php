<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\SaveToDatabase;
use App\Entity\Product;

class DeleteProduct
{
    public function __construct(private EntityManagerInterface $em, private SaveToDatabase $save)
    {
    }

    public function delete(int $productId) : bool
    {   
        $product = $this->em->getRepository(Product::class)->findOneBy([
            'id' => $productId,
            'isDeleted' => false
        ]);
        if($product){
            $product->setIsDeleted(true);
            $this->save->save($product);
            return true;
        }
        else{
            return false;
        }
    }
}