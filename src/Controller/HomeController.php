<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProductRepository $productRepository, EntityManagerInterface $em, UserPasswordHasherInterface $userPasswordHasher): Response
    {
//        $user = new User();
//        $user->setUsername('Mounir')
//            ->setEmail('hassine.mounir1234@gmail.com')
//            ->setPassword($userPasswordHasher->hashPassword($user, 'Mounir'))
//            ->setRoles(['ROLE_ADMIN']);
//        $em->persist($user);
//        $em->flush();

        $products = $productRepository->findLatest();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'products' => $products
        ]);
    }
}