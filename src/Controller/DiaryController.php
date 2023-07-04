<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ChooseDayFormType;
use App\Form\ChooseProductFormType;
use App\Entity\Diary;
use App\Entity\Product;
use App\Entity\Nutrient;
use App\Service\ValidateDate;
use App\Service\SaveToDatabase;
use App\Service\SetNutrientsToDiary;
use App\Service\ValidateQuantity;
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
    public function showDay($date, Request $request, SetNutrientsToDiary $setNutrients, ValidateDate $validateDate, ValidateQuantity $validate, EntityManagerInterface $em, SaveToDatabase $save): Response
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
            if($diaries){
                $diaries = $setNutrients->set($diaries);
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
                'chooseProductForm' => $chooseProductForm
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