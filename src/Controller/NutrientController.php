<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AddNutrientFormType;
use App\Entity\Nutrient;
use App\Entity\Target;
use App\Form\EditNutrientTargetFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\ObjectDeleter\ObjectDeleter;
use App\Service\ObjectDeleter\NutrientDeleter;
use App\Service\Nutrient\AddNutrient;
use App\Service\Nutrient\SetTargetToNutrients;
use App\Service\Target\GetTarget;
use App\Service\Target\GetTargets;
use DateTime;

class NutrientController extends AbstractController
{
    #[Route('/nutrients', name: 'nutrients')]
    public function showNutrients(Request $request, EntityManagerInterface $em, NutrientDeleter $nutrientDeleter, AddNutrient $addNutrient, SetTargetToNutrients $setTarget): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_USER');
        $nutrient = new Nutrient();
        $addNutrientForm = $this->createForm(AddNutrientFormType::class, $nutrient)->handleRequest($request);

        # adds nutrient
        if ($addNutrientForm->isSubmitted() && $addNutrientForm->isValid() && $addNutrientForm->get('name')->getData() !== null) {
            $nutrient->setName($addNutrientForm->get('name')->getData())->setUser($this->getUser())->setTarget($addNutrientForm->get('target')->getData());
            $addNutrient->add($nutrient);
            return $this->redirectToRoute('nutrients');
        }

        # deletes nutrient
        if ($request->request->get('deleteNutrientId')) {
            $nutrient = $em->getRepository(Nutrient::class)->find($request->request->get('deleteNutrientId'));
            if ($nutrient) {
                $deleter = new ObjectDeleter($nutrientDeleter);
                $deleter->delete($nutrient);
                $this->addFlash(
                    'positive', 
                    'Nutrient was deleted.');
                return $this->redirectToRoute('nutrients');
            }
        }

        $nutrients = $em->getRepository(Nutrient::class)->findBy(['User' => $this->getUser()]);
        return $this->render('nutrient/nutrients.html.twig', [
            'addNutrientForm' => $addNutrientForm,
            'nutrients' => $setTarget->set($nutrients),
        ]);
    }

    #[Route('/nutrient/{id}', name: 'nutrient')]
    public function showNutrient($id, EntityManagerInterface $em, GetTarget $getTarget, Request $request, GetTargets $getTargets): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $nutrient = $em->getRepository(Nutrient::class)->findOneBy([
            'id' => $id,
            'User' => $this->getUser(),
        ]);
        if (!$nutrient) {
            $this->addFlash(
                'negative',
                'Nutrient not found.'
            );
            return $this->redirectToRoute('nutrients');
        }

        $target = new Target;
        $editNutrientTargetForm = $this->createForm(EditNutrientTargetFormType::class, $target)->handleRequest($request);
        if ($editNutrientTargetForm->isSubmitted() && $editNutrientTargetForm->isValid()) {
            $target->setUser($this->getUser())->setNutrient($nutrient)->setValue($editNutrientTargetForm->get('value')->getData())->setDate(new DateTime('now'));
            $em->persist($target);
            $em->flush();
            $this->addFlash(
                'positive',
                'Nutrient target has been edited.'
            );
            return $this->redirectToRoute('nutrient', ['id' => $nutrient->getId()]);
        }
        $nutrient->setTarget($getTarget->get($nutrient, $this->getUser(), new DateTime('now')));
        return $this->render('nutrient/nutrient.html.twig', [
            'nutrient' => $nutrient,
            'editNutrientTargetForm' => $editNutrientTargetForm,
            'targets' => $getTargets->get($nutrient),
        ]);
    }
}
