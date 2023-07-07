<?php

namespace App\Service\Target;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Form;
use App\Service\SaveToDatabase;
use App\Entity\NutrientHasTarget;
use App\Entity\User;
use App\Entity\Nutrient;

class EditNutrientTarget
{
    public function __construct(private EntityManagerInterface $em, private SaveToDatabase $save)
    {

    }

    # Adds or edits nutrient targets
    public function edit(Form $form, User $user) : bool
    {
        $nutrients = $this->em->getRepository(Nutrient::class);
        $nutrientHasTarget = $this->em->getRepository(NutrientHasTarget::class);
        $target = $nutrientHasTarget->findOneBy(['userId' => $user->getId(), 'nutrient' => $nutrients->findOneBy(['name' => $this->nutrientName])]);
        if($target){
 
            $target->setTarget(round($form->get($this->nutrientName)->getData(), 2));
            $this->save->save($target);
            return true;
        }
        else{
            $nutrientHasTarget = new NutrientHasTarget();
            $nutrientHasTarget
                ->setNutrient($nutrients->findOneBy(['name' => $this->nutrientName]))
                ->setUserId($user->getId())
                ->setTarget(round($form->get($this->nutrientName)->getData(), 2))
            ;
            $this->save->save($nutrientHasTarget);
            return true;
        }
    }
}