<?php

namespace App\Service;

use Symfony\Component\Form\Form;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\ProductHasNutrients;
use App\Service\ProcessEditFatForm;
use App\Service\SaveToDatabase;
use App\Entity\Nutrient;
use App\Entity\Product;

class ProcessEditForm
{
    private Nutrient $nutrient;
    private ProductHasNutrients $productHasNutrients;

    public function __construct(private EntityManagerInterface $em, private SaveToDatabase $save)
    {
       
    }

    public function process(Form $form, Product $product) : bool
    {
        $this->nutrient = $this->em->getRepository(Nutrient::class)->findOneBy(['name' => $this->nutrientName]);
        if($form->isSubmitted() && $form->isValid() && $form->get($this->nutrient->getName())->getData() !== null){
            $this->productHasNutrients = $this->em->getRepository(ProductHasNutrients::class)->findOneBy([
                'products' => $product->getId(),
                'nutrients' => $this->nutrient->getId()
            ]);
            $this->productHasNutrients->setQuantity($form->get($this->nutrient->getName())->getData());
            $this->save->save($this->nutrient);
            return true;
        }
        else{
            return false;
        }
    }
}
