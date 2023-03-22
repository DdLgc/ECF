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
            'isAdmin'=> false,
        ]);
    }
    #[Route('/login/register', name: 'app_login_register')]
    public function register(): Response
    {
        return $this->render('layouts/register/index.html.twig', [
            'controller_name' => 'LoginController',
            'user'=> new User(),
            'isAdmin'=> false,
        ]);
    }
    #[Route('/login/edit/{id}', name: 'app_login_edit')]
    public function edit($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        return $this->render('layouts/register/index.html.twig', [
            'controller_name' => 'LoginController',
            'user' => $user,
            'isAdmin'=> false,
        ]);
    }
    #[Route('/login/register/post/{id}', name: 'app_login_register_post')]
public function post(Request $request, UserPasswordHasherInterface $passwordHasher, $id): Response
{
    $entityManager = $this->getDoctrine()->getManager();
    if (isset($id) && $id!=0){
        $user = $entityManager->getRepository(User::class)->find($id);
    }
    else {
        $user = new User();
    }
    $user->setPassword(
        $passwordHasher->hashPassword(  $user,
            $request->request->get("password"))
    );
    $user->setEmail($request->request->get("email"));
    $user->setTelephone($request->request->get("telephone"));
    $user->setName($request->request->get("name"));
    $entityManager->persist($user);
    $entityManager->flush();
    return $this->render('login/index.html.twig', [
        'controller_name' => 'LoginController',
        'isAdmin'=> false,
    ]);
}
}
