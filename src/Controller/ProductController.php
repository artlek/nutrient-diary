<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GetProductList;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'products')]
    public function showProductList(GetProductList $products): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_USER');
        return $this->render('products.html.twig', [
            'products' => $products->getProductList($this->getUser()->getId()),
        ]);
    }
}
