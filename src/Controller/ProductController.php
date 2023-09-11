<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AddProductFormType;
use App\Form\EditFatFormType;
use App\Form\EditCarboFormType;
use App\Form\EditProteinFormType;
use App\Form\EditKcalFormType;
use App\Entity\Product;
use App\Entity\ProductHasNutrients;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\AddProduct;
use App\Service\CheckIfProductExist;
use App\Service\ProcessEditFatForm;
use App\Service\ProcessEditCarboForm;
use App\Service\ProcessEditProteinForm;
use App\Service\ProcessEditKcalForm;
use App\Service\DeleteProductFromDiary;
use App\Service\DeleteProduct;
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

    #[Route('/add-product', name: 'add-product')]
    public function addProduct(Request $request, EntityManagerInterface $em, AddProduct $addProduct, CheckIfProductExist $check): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_USER');
        $product = new Product();
        $form = $this->createForm(AddProductFormType::class, $product)->handleRequest($request);
        if($form->isSubmitted() && $form->isValid() && $form->get('name')->getData() !== null && $form->get('fat')->getData() !== null && $form->get('carbo')->getData() !== null && $form->get('protein')->getData() !== null && $form->get('kcal')->getData() !== null){
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

    #[Route('/product/{id}', name: 'product')]
    public function showProduct($id, Request $request, EntityManagerInterface $em, ProcessEditFatForm $fatForm, ProcessEditCarboForm $carboForm, ProcessEditProteinForm $proteinForm, ProcessEditKcalForm $kcalForm): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_USER');
        $product = $em->getRepository(Product::class)->findOneBy([
            'id' => $id, 
            'isDeleted' => false,
            'user' => $this->getUser()
        ]);
        if($product){
            $product
                ->setFat($product->getHasNutrients()->get(0)->getQuantity())
                ->setCarbo($product->getHasNutrients()->get(1)->getQuantity())
                ->setProtein($product->getHasNutrients()->get(2)->getQuantity())
                ->setKcal($product->getHasNutrients()->get(3)->getQuantity())
            ;
            $editFatForm = $this->createForm(EditFatFormType::class)->handleRequest($request);
            $editCarboForm = $this->createForm(EditCarboFormType::class)->handleRequest($request);
            $editProteinForm = $this->createForm(EditProteinFormType::class)->handleRequest($request);
            $editKcalForm = $this->createForm(EditKcalFormType::class)->handleRequest($request);
            if($fatForm->process($editFatForm, $product)){
                $this->addFlash(
                    'positive',
                    'Product nutrient was edited'
                );
                return $this->redirect($id);
            }
            if($carboForm->process($editCarboForm, $product)){
                $this->addFlash(
                    'positive',
                    'Product nutrient was edited'
                );
                return $this->redirect($id);
            }
            if($proteinForm->process($editProteinForm, $product)){
                $this->addFlash(
                    'positive',
                    'Product nutrient was edited'
                );
                return $this->redirect($id);
            }
            if($kcalForm->process($editKcalForm, $product)){
                $this->addFlash(
                    'positive',
                    'Product nutrient was edited'
                );
                return $this->redirect($id);
            }
            return $this->render('product.html.twig', [
                'product' => $product,
                'editFatForm' => $editFatForm,
                'editCarboForm' => $editCarboForm,
                'editProteinForm' => $editProteinForm,
                'editKcalForm' => $editKcalForm
            ]);
        }
        else {
            $this->addFlash(
                'negative',
                'Product not found'
            );
            return $this->redirectToRoute('products');
        }
    }

    #[Route('/delete-product-from-diary', name: 'delete-product-from-diary')]
    public function deleteProductFromDiary(DeleteProductFromDiary $delete): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_USER');
        if(isset($_POST['delete-product'])){
            if($delete->delete($_POST['delete-product'])){
                $this->addFlash(
                    'positive',
                    'Product was deleted from diary'
                );
            }
            return $this->redirectToRoute('date', ['date' => $_POST['date']]);
        }
        else{
            $this->addFlash(
                'negative',
                'Product not found'
            );
            return $this->redirectToRoute('diary');
        }
    }

    #[Route('/delete-product', name: 'delete-product')]
    public function deleteProduct(DeleteProduct $delete): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_USER');
        if(isset($_POST['productId'])){
            if($delete->delete($_POST['productId'])){
                $this->addFlash(
                    'positive',
                    'Product was deleted'
                );
            }
        }
        return $this->redirectToRoute('products');
    }
}
