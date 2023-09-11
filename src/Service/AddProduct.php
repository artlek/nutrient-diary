<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\SaveToDatabase;
use App\Entity\Nutrient;
use App\Entity\ProductHasNutrients;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Product;

class AddProduct
{
    public function __construct(
        private SaveToDatabase $save, 
        private EntityManagerInterface $em, 
        private Security $security)
    {
    }

    public function add(Product $product)
    {
        $nutrient = new Nutrient();
        $product
            ->setIsDeleted(false)
            ->setUser($this->security->getUser())
        ;
        $this->save->save($product);

        $productHasNutrients = new ProductHasNutrients();
        $productHasNutrients
            ->setProducts($product)
            ->setNutrients($this->em->getRepository(Nutrient::class)->findOneBy(['name' => 'fat']))
            ->setQuantity($product->getFat())
        ;
        $this->save->save($productHasNutrients);

        $productHasNutrients = new ProductHasNutrients();
        $productHasNutrients
            ->setProducts($product)
            ->setNutrients($this->em->getRepository(Nutrient::class)->findOneBy(['name' => 'carbo']))
            ->setQuantity($product->getCarbo())
        ;
        $this->save->save($productHasNutrients);

        $productHasNutrients = new ProductHasNutrients();
        $productHasNutrients
            ->setProducts($product)
            ->setNutrients($this->em->getRepository(Nutrient::class)->findOneBy(['name' => 'protein']))
            ->setQuantity($product->getProtein())
        ;
        $this->save->save($productHasNutrients);

        $productHasNutrients = new ProductHasNutrients();
        $productHasNutrients
            ->setProducts($product)
            ->setNutrients($this->em->getRepository(Nutrient::class)->findOneBy(['name' => 'kcal']))
            ->setQuantity($product->getKcal())
        ;
        $this->save->save($productHasNutrients);

        return true;
    }
}