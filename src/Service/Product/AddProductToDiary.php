<?php

namespace App\Service\Product;

use App\Entity\Diary;
use DateTime;
use App\Entity\User;
use App\Entity\Product;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityManagerInterface;

class AddProductToDiary
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }

    public function add(string $date, User $user, FormInterface $form): void
    {
        $diary = new Diary;
        $diary
            ->setDate(new DateTime($date))
            ->setUser($user)
            ->setProduct($this->em->getRepository(Product::class)->find($form->getData()['productId']))
            ->setQuantity($form->getData()['quantity'])
        ;
        $this->em->persist($diary);
        $this->em->flush($diary);
    }
}