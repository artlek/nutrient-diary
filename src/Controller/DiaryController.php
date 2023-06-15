<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiaryController extends AbstractController
{
    #[Route('/diary', name: 'diary')]
    public function showDay(): Response
    {
        return $this->render('diary.html.twig', [
            'controller_name' => 'DayController',
        ]);
    }
}
