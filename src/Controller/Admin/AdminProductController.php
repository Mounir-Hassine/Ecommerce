<?php
namespace App\Controller\Admin;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
class AdminProductController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin/all', name: 'admin_product_all', methods: ['GET'])]
    public function index(): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();
        return $this->render('admin/product/index.html.twig', ['products' => $products]);
    }

    #[Route('/admin/product_edit/{id}', name: 'admin_product_edit', methods: ['GET', 'POST'])]
    public function edit(Product $product, Request $request): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ensure the entity is managed
            $this->entityManager->persist($product);
            $this->entityManager->flush();

            $this->addFlash('success', 'Product updated successfully');
            return $this->redirectToRoute('admin_product_all');
        }

        return $this->render('admin/product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/new', name: 'admin_product_new')]
    public function new(Request $request, ValidatorInterface $validator): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        $errors = $validator->validate($product);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($product);
            $this->entityManager->flush();
            $this->addFlash('success', 'Product created successfully');
            return $this->redirectToRoute('admin_product_all');
        }
        return $this->render('admin/product/new.html.twig', ['form' => $form->createView(), 'product' => $product, 'errors' => $errors]);
    }

    #[Route('/admin/product_delete/{id}', name: 'admin_product_delete')]
    public function delete(Product $product, Request $request): Response
    {

            $this->entityManager->remove($product);
            $this->entityManager->flush();
            $this->addFlash('success', 'Product deleted successfully');


        return $this->redirectToRoute('admin_product_all');
    }
}