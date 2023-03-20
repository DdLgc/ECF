<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function index(): Response
    {
        return $this->render('login/index.html.twig', [
            'controller_name' => 'LoginController',
        ]);
    }#[Route('/login/register', name: 'app_login_register')]
    public function register(): Response
    {
        return $this->render('layouts/register/index.html.twig', [
            'controller_name' => 'LoginController',
            'user'=> new User()
        ]);
    }#[Route('/login/register/post', name: 'app_login_register_post')]
public function post(Request $request, UserPasswordHasherInterface $passwordHasher): Response
{
    $user = new User();
    $user->setPassword(
        $passwordHasher->hashPassword(  $user,
            $request->request->get("password"))
    );
    $user->setEmail($request->request->get("email"));
    $user->setTelephone($request->request->get("telephone"));
    $user->setName($request->request->get("name"));
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($user);
    $entityManager->flush();
    return $this->redirectToRoute('app_login');
}
}
