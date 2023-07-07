<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ChooseDayFormType;
use App\Form\ChooseProductFormType;
use App\Form\EditFatTargetFormType;
use App\Form\EditCarboTargetFormType;
use App\Form\EditProteinTargetFormType;
use App\Entity\Diary;
use App\Entity\Product;
use App\Entity\Nutrient;
use App\Entity\NutrientHasTarget;
use App\Service\Target\Target;
use App\Service\Target\FatTarget;
use App\Service\Target\CarboTarget;
use App\Service\Target\ProteinTarget;
use App\Service\Target\EditFatTarget;
use App\Service\Target\EditCarboTarget;
use App\Service\Target\EditProteinTarget;
use App\Service\ValidateDate;
use App\Service\SaveToDatabase;
use App\Service\SetNutrientsToDiary;
use App\Service\ValidateQuantity;
use App\Service\EditNutrientTarget;
use App\Service\DailyConsumption\DailyFatConsumption;
use App\Service\DailyConsumption\DailyCarboConsumption;
use App\Service\DailyConsumption\DailyProteinConsumption;
use Doctrine\ORM\EntityManagerInterface;
use DateTimeImmutable;

class DiaryController extends AbstractController
{
    #[Route('/date', name: 'diary')]
    public function showToday(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->redirectToRoute('date', ['date' => date("Y-m-d")]);
    }

    #[Route('/date/{date}', name: 'date')]
    public function showDay($date, Request $request, EditFatTarget $editFatTarget, EditCarboTarget $editCarboTarget, EditProteinTarget $editProteinTarget, SetNutrientsToDiary $setNutrients, FatTarget $fatTarget, CarboTarget $carboTarget, ProteinTarget $proteinTarget, ValidateDate $validateDate, ValidateQuantity $validate, EntityManagerInterface $em, SaveToDatabase $save, DailyFatConsumption $fatConsumption, DailyCarboConsumption $carboConsumption, DailyProteinConsumption $proteinConsumption): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_USER');
        $diary = new Diary();
        $dateForm = $this->createForm(ChooseDayFormType::class, $diary);
        $dateForm->handleRequest($request);
        $chooseProductForm = $this->createForm(ChooseProductFormType::class);
        $chooseProductForm->handleRequest($request);
        if($dateForm->isSubmitted() && $dateForm->isValid()) {
            return $this->redirectToRoute('date', ['date' => $dateForm->get('date')->getData()]);
        }
        if($validateDate->validate($date)){
            $diaries = $em->getRepository(Diary::class)->findBy(['user' => $this->getUser()->getId(), 'date' => $date]);
            $nutrients = $em->getRepository(Nutrient::class);
            $targetsRepo = $em->getRepository(NutrientHasTarget::class);
            $nutrientTarget = [
                'fat' => $fatTarget->get($this->getUser()),
                'carbo' => $carboTarget->get($this->getUser()),
                'protein' => $proteinTarget->get($this->getUser())
            ];
            $nutrientConsumption = [
                'fat' => $fatConsumption->compute($date, $this->getUser()),
                'carbo' => $carboConsumption->compute($date, $this->getUser()),
                'protein' => $proteinConsumption->compute($date, $this->getUser())
            ];
            if($diaries){
                $diaries = $setNutrients->set($diaries);
            }
            $editFatTargetForm = $this->createForm(EditFatTargetFormType::class);
            $editFatTargetForm->handleRequest($request);
            if($editFatTargetForm->isSubmitted() && $editFatTargetForm->isValid()){
                if($validate->validate($editFatTargetForm->get('fat')->getData()) AND $editFatTarget->edit($editFatTargetForm, $this->getUser())){
                    $this->addFlash(
                        'positive',
                        'Fat target have been saved'
                    );
                    return $this->redirectToRoute('date', ['date' => $date]);
                }
            }
            $editCarboTargetForm = $this->createForm(EditCarboTargetFormType::class);
            $editCarboTargetForm->handleRequest($request);
            if($editCarboTargetForm->isSubmitted() && $editCarboTargetForm->isValid()){
                if($validate->validate($editCarboTargetForm->get('carbo')->getData()) AND $editCarboTarget->edit($editCarboTargetForm, $this->getUser())){
                    $this->addFlash(
                        'positive',
                        'Carbo target have been saved'
                    );
                    return $this->redirectToRoute('date', ['date' => $date]);
                }
            }
            $editProteinTargetForm = $this->createForm(EditProteinTargetFormType::class);
            $editProteinTargetForm->handleRequest($request);
            if($editProteinTargetForm->isSubmitted() && $editProteinTargetForm->isValid()){
                if($validate->validate($editProteinTargetForm->get('protein')->getData()) AND $editProteinTarget->edit($editProteinTargetForm, $this->getUser())){
                    $this->addFlash(
                        'positive',
                        'Protein targets have been saved'
                    );
                    return $this->redirectToRoute('date', ['date' => $date]);
                }
            }
            if($chooseProductForm->isSubmitted() && $chooseProductForm->isValid()) {
                if($validate->validate($chooseProductForm->get('quantity')->getData())){
                    $diary = new Diary();
                    $diary
                        ->setProduct($em->getRepository(Product::class)->findOneBy(['id' => $chooseProductForm->get('productId')->GetData()]))
                        ->setUser($this->getUser())
                        ->setDate($date)
                        ->setDatetime(new DateTimeImmutable())
                        ->setQuantity(round($chooseProductForm->get('quantity')->getData(), 2))
                    ;
                    $save->save($diary);
                }
                else{
                    $this->addFlash(
                        'negative',
                        'Invalid product quantity'
                    );
                }
                return $this->redirectToRoute('date', ['date' => $date]);
            }
            return $this->render('diary.html.twig', [
                'dateForm' => $dateForm,
                'date' => $date,
                'diaries' => $diaries,
                'chooseProductForm' => $chooseProductForm,
                'nutrientTarget' => $nutrientTarget,
                'nutrientConsumption' => $nutrientConsumption,
                'editFatTargetForm' => $editFatTargetForm,
                'editCarboTargetForm' => $editCarboTargetForm,
                'editProteinTargetForm' => $editProteinTargetForm,
            ]);
        }
        else{
            $this->addFlash(
                'negative',
                'Invalid date'
            );
            return $this->redirectToRoute('diary');
        }
    }
}