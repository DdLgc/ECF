<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $admins = $entityManager->getRepository(User::class)->findBy(["is_admin"=>true]);
        return $this->render('layouts/administration.html.twig', [
            'controller_name' => 'AdminController',
            "admins"=> $admins,
        ]);
    }
    #[Route('/admin/add', name: 'app_admin_add')]
    public function add(Request $request): Response
    {
        $user = new User();
        return $this->render('administrationForm.html.twig', [
            'user'=> $user
        ]);
    }#[Route('/admin/post', name: 'app_admin_post')]
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
        $user->setIsAdmin(true);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin');
    }
#[Route('/admin/edit/{id}', name: 'app_admin_edit')]
    public function edit(Request $request, $id,UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id) ;
        $user->setPassword(
            $passwordHasher->hashPassword(  $user,
                $request->request->get("password"))
        );
        $user->setEmail($request->request->get("email"));
        $user->setTelephone($request->request->get("telephone"));
        $user->setName($request->request->get("name"));
        $user->setIsAdmin(true);

            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin');
    }

#[Route('/admin/delete/{id}', name: 'app_admin_delete')]
    public function delete(Request $request, $id,UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id) ;
        $entityManager->remove($user);
            $entityManager->flush();
            return $this->redirectToRoute('app_admin');
    }
    #[Route('/admin/form/edit/{id}', name: 'app_form_edit')]
    public function form_edit($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id) ;
        return $this->render('administrationForm.html.twig', [
            'controller_name' => 'AdminController',
            'user'=> $user
        ]);
    }
}
