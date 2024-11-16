<?php

namespace App\Controller;

use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductsController extends AbstractController
{
    #[Route('/products', name: 'products.index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {

//        $product = new Product();
//
//        $product->setTitle('first product')
//            ->setDescription('This is a good product')
//            ->setPrix(20);
//
//
//        $entityManager->persist($product);
//        $entityManager->flush();
        $repo = $entityManager->getRepository(Product::class);
        $data = $repo->findAll();

        return $this->render('Products/index.html.twig', [
            'controller_name' => 'ProductsController',
        ]);
    }

    #[Route('/products/{slugify}-{id}', name: 'products.show', methods: ['GET'], requirements: ['slugify' => '[a-zA-Z0-9_-]+'])]
    public function show(Product $product, string $slugify): Response
    {
        if($product->getSlugify() != $slugify) {
            return $this->redirectToRoute(
                'products.show',
                ['slugify' => $product->getSlugify(),
                    'id' => $product->getId()], 301
            );
        }
        return $this->render('Products/show.html.twig', ['product' => $product]);
    }


}