<?php

namespace App\Controller;

use App\Entity\Nutrient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\AddProductFormType;
use App\Entity\Product;
use App\Service\ObjectNameChecker\ObjectNameChecker;
use App\Service\ObjectNameChecker\CheckProductNameExist;
use Doctrine\ORM\EntityManagerInterface;
use App\Service\ObjectDeleter\ProductDeleter;
use App\Service\ObjectDeleter\ObjectDeleter;
use App\Service\Product\AddProduct;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\SetObjectCounter;

class ProductController extends AbstractController
{
    #[Route('/products', name: 'products')]
    public function showProducts(
        Request $request, EntityManagerInterface $em, CheckProductNameExist $checkProductNameExist, ProductDeleter $productDeleter, AddProduct $addProduct, PaginatorInterface $paginator, SetObjectCounter $setObjectCounter): Response
    {   
        $this->denyAccessUnlessGranted('ROLE_USER');
        $nutrients = $em->getRepository(Nutrient::class)->findBy(['User' => $this->getUser()]);
        $addProductForm = $this->createForm(AddProductFormType::class)->handleRequest($request);
        
        if ($addProductForm->isSubmitted() && $addProductForm->isValid()) {
            $product = new Product();
            $product->setUser($this->getUser())->setName($addProductForm->getData()['name']);
            $checker = new ObjectNameChecker($checkProductNameExist);
            if ($checker->check($product)){
                $this->addFlash(
                    'negative', 
                    $product->getName() . ' product already exists.');
            }
            else{
                $addProduct->add($product, $addProductForm);
                $this->addFlash(
                    'positive', 
                    $product->getName() . ' has been added.');
            }
            return $this->redirectToRoute('products');
        }

        if ($request->request->get('DeleteProductId')) {
            $product = $em->getRepository(Product::class)->findOneBy(['id' => $request->request->get('DeleteProductId')]);
            $deleter = new ObjectDeleter($productDeleter);
            $deleter->delete($product);
            $this->addFlash(
                'positive', 
                'Product ' . $product->getName() .  ' has been deleted.');
            return $this->redirectToRoute('products');
        }

        $products = $em->getRepository(Product::class)->findBy([
            'isDeleted' => false,
            'User' => $this->getUser(),
            ]);
        $setObjectCounter->set($products);

        $pagination = $paginator->paginate(
            $products,
            $request->query->getInt('page', 1),
            8 /*limit per page*/
        );

        return $this->render('product/products.html.twig', [
            'addProductForm' => $addProductForm,
            'nutrients' => $nutrients,
            'pagination' => $pagination,
            'products' => $products
        ]);
    }
}
