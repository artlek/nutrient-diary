<?php

namespace App\Service\Product;

use App\Entity\Nutrient;
use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\ProductHasNutrients;
use Symfony\Component\Form\FormInterface;

class AddProduct
{
    public function __construct(private EntityManagerInterface $em, private Security $security)
    {

    }

    public function add(Product $product, FormInterface $form): void
    {
        try {
            foreach ($this->getNutrients($this->security->getUser()) as $nutrient) {
                $product_has_nutrients = new ProductHasNutrients;
                $product_has_nutrients
                    ->setProduct($product)
                    ->setNutrient($nutrient)
                    ->setContent($form->getData()[$nutrient->getName()]);
                $this->em->persist($product_has_nutrients);
                $this->em->flush();
            }
            $this->em->persist($product);
            $this->em->flush();
        }
        catch (\Exception $e) {
            error_log($e->getMessage());
        }
    }

    private function getNutrients(User $user): array
    {
        return $this->em->getRepository(Nutrient::class)->findBy(['User' => $user]);
    }
}