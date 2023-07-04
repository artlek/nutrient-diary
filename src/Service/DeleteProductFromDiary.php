<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\SaveToDatabase;
use App\Entity\Diary;

class DeleteProductFromDiary
{
    public function __construct(private EntityManagerInterface $em, private SaveToDatabase $save)
    {
    }

    public function delete(int $id) : bool
    {   
        $product = $this->em->getRepository(Diary::class)->findOneBy(['id' => $id]);
        if($product){
            $this->save->delete($product);
            return true;
        }
        else{
            return false;
        }
    }
}