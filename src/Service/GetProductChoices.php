<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Product;

class GetProductChoices
{
    public function __construct(private EntityManagerInterface $em, private Security $security)
    {
    }

    # gets array of product choices (to render SelectProductFormType)
    public function get() : array
    {
        $choices = $this->em->getRepository(Product::class)->findBy([
            'user' => $this->security->getUser()->getId(), 'isDeleted' => false],
            ['name' => 'ASC']
        );
        $array = array();
        if($choices){
            for($i = 0; $i < count($choices); $i++){
                $array[$choices[$i]->getName()] = $choices[$i]->getId();
            }
        }
        return $array;
    }
}