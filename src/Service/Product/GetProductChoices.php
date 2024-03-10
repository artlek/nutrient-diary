<?php

namespace App\Service\Product;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Product;

class GetProductChoices
{
    private array $products;
    private array $order = ['name' => 'ASC'];
    private array $productsArray;

    public function __construct(private EntityManagerInterface $em, private Security $security)
    {
        $this->products = $this->getProducts();
    }
    
    # gets array of product choices (need to add product form)
    public function get(): array
    {
        $this->productsArray = array();
        if ($this->products) {
            for ($i = 0; $i < count($this->products); $i++) {
                $this->productsArray[$this->products[$i]->getName()] = $this->products[$i]->getId();
            }
        }
        return $this->productsArray;
    }

    private function getProducts(): array
    {
        return $this->em->getRepository(Product::class)->findBy(['User' => $this->security->getUser(), 'isDeleted' => false], $this->order);
    }
}