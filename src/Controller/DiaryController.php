<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ChooseDayFormType;
use App\Form\AddProductToDiaryFormType;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Product;
use App\Entity\Diary;
use App\Service\Diary\ValidateDate;
use App\Service\Product\AddProductToDiary;
use App\Service\Nutrient\GetDailyNutrientSummary;
use DateTime;
use App\Service\ObjectDeleter\ObjectDeleter;
use App\Service\ObjectDeleter\DiaryDeleter;

class DiaryController extends AbstractController
{
    #[Route('/diary', name: 'diary')]
    public function showDiary(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->redirectToRoute('date', ['date' => date("Y-m-d")]);
    }

    #[Route('/date/{date}', name: 'date')]
    public function showDay($date, Request $request, EntityManagerInterface $em, ValidateDate $validateDate, AddProductToDiary $addProductToDiary, GetDailyNutrientSummary $nutrientSummary, DiaryDeleter $diaryDeleter): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_USER');
        $dateForm = $this->createForm(ChooseDayFormType::class);
        $dateForm->handleRequest($request);
        $addProductToDiaryForm = $this->createForm(AddProductToDiaryFormType::class);
        $addProductToDiaryForm->handleRequest($request);
        $allProducts = $em->getRepository(Product::class);

        if ($dateForm->isSubmitted() AND $dateForm->isValid()) {
            return $this->redirectToRoute('date', ['date' => $dateForm->getData()['date']]);
        }

        if (!$validateDate->validate($date)) {
            return $this->redirectToRoute('diary');
        }

        if ($request->request->get('deleteProductId')) {
            $diary = $em->getRepository(Diary::class)->find($request->request->get('deleteProductId'));
            if($diary){
                $deleter = new ObjectDeleter($diaryDeleter);
                $deleter->delete($diary);
                $this->addFlash(
                'positive', 
                'Product has been deleted from diary.');
            }
        }

        if ($addProductToDiaryForm->isSubmitted() AND $addProductToDiaryForm->isValid()) {
            $addProductToDiary->add($date, $this->getUser(), $addProductToDiaryForm);
            $this->addFlash(
                'positive', 
                'Product ' . $allProducts->find($addProductToDiaryForm->getData()['productId'])->getName() . ' was added to diary.');
            return $this->redirectToRoute('date', ['date' => $date]);
        }

        return $this->render('diary/diary.html.twig', [
            'dateForm' => $dateForm,
            'date' => $date,
            'addProductToDiary' => $addProductToDiaryForm,
            'products' => $allProducts->findBy(['User' => $this->getUser(), 'isDeleted' => false]),
            'productsInDiary' => $em->getRepository(Diary::class)->findBy(['user' => $this->getUser(), 'date' => DateTime::createFromFormat('Y-m-d', $date)]),
            'summary' => $nutrientSummary->get(new DateTime($date), $this->getUser()),
        ]);
    }
}