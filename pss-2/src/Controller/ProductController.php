<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\User;
use App\Entity\Product;
use App\Entity\UserProfile;
use App\Form\ProductType;
use App\Form\UserType;
use App\Repository\CartRepository;
use App\Repository\UserRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\String\Slugger\SluggerInterface;

class ProductController extends AbstractController
{
    private Security $security;
    private EntityManagerInterface $em;
    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em = $em;
    }

    #[Route('/product', name: 'app_product')]
    public function index(ProductRepository $products): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $products->findAll(),
        ]);
    }

    #[Route('/product/{product}', name: 'app_product_show', requirements: ['product' => '\d+'])]
    public function showOne(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/product/add', name: 'app_product_add', priority: 2)]
    #[IsGranted('ROLE_WORKER')]
    public function add(Request $request, ProductRepository $products, SluggerInterface $slugger ): Response 
    {
        $form = $this->createForm(ProductType::class, new Product());
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           $product = $form->getData();
           $productImageFile = $form->get('productImage')->getData();
           
           if($productImageFile){
            
                $originalFileName = pathinfo(
                    $productImageFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $safeFilename = $slugger->slug($originalFileName);
                $newFileName = $safeFilename.'-'.uniqid().'.'. $productImageFile->guessExtension();

                try {
                    $productImageFile->move(
                        $this->getParameter('products_directory'),
                        $newFileName
                    );
           } catch (FileException $e){
           }

           $product -> setImage($newFileName);
        } 
           $products -> save($product, true);

           
           $this -> addFlash('success', 'Product have been added');

           
           return $this->redirectToRoute('app_product');
        }
        return $this->render(
            'product/add.html.twig', [
                'form' => $form
            ]);

    }
    
    #[Route('/product/{product}/edit', name: 'app_product_edit')]
    #[IsGranted('ROLE_WORKER')]
    public function edit(Product $product, Request $request, ProductRepository $products, SluggerInterface $slugger): Response 
    {
        $form = $this->createForm(ProductType::class, $product);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
           $product = $form->getData();
           $productImageFile = $form->get('productImage')->getData();
           
           if($productImageFile){
            
                $originalFileName = pathinfo(
                    $productImageFile->getClientOriginalName(),
                    PATHINFO_FILENAME
                );
                $safeFilename = $slugger->slug($originalFileName);
                $newFileName = $safeFilename.'-'.uniqid().'.'. $productImageFile->guessExtension();

                try {
                    $productImageFile->move(
                        $this->getParameter('products_directory'),
                        $newFileName
                    );
           } catch (FileException $e){
           }

           $product -> setImage($newFileName);
        } 
           $products -> save($product, true);

           
           $this -> addFlash('success', 'Product have been updated');

           
           return $this->redirectToRoute('app_product');
        }
        return $this->render(
            'product/edit.html.twig', [
                'form' => $form,
                'product' => $product
            ]);

    }
    
 }
