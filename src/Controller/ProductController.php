<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\GetProductList;
use App\Form\AddProductFormType;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\AddProduct;
use App\Service\CheckIfProductExist;

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

    #[Route('/add-product', name: 'add-product')]
    public function addProduct(Request $request, EntityManagerInterface $em, AddProduct $addProduct, CheckIfProductExist $check): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_USER');
        $product = new Product();
        $form = $this->createForm(AddProductFormType::class, $product)->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            if($check->check($product->getName(), $this->getUser())){
                $this->addFlash(
                    'negative',
                    'Product ' .$product->getName() . ' already exists'
                );
                return $this->redirectToRoute('add-product');
            }
            else{
                if($addProduct->add($product)){
                    $this->addFlash(
                        'positive',
                        'Product ' .$product->getName() . ' has been added'
                    );
                    return $this->redirectToRoute('products');
                }
            }
        }
        return $this->render('add-product.html.twig', [
            'addProductForm' => $form,
        ]);
    }
}
