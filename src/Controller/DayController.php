<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DayController extends AbstractController
{
    #[Route('/day', name: 'day')]
    public function showDay(): Response
    {
        return $this->render('day.html.twig', [
            'controller_name' => 'DayController',
        ]);
    }
}
