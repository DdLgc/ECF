<?php

namespace App\Controller;

use App\Entity\Gallerie;
use App\Entity\Horaire;
use App\Entity\User;
use App\Form\ImageType;
use Doctrine\ORM\Mapping\Id;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\String\Slugger\SluggerInterface;
use function Symfony\Component\String\u;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $admins = $entityManager->getRepository(User::class)->findBy(["is_admin" => true]);
        return $this->render('layouts/administration.html.twig', [
            'controller_name' => 'AdminController',
            "admins" => $admins,
        ]);
    }

    #[Route('/admin/add', name: 'app_admin_add')]
    public function add(Request $request): Response
    {
        $user = new User();
        return $this->render('administrationForm.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/admin/post', name: 'app_admin_post')]
    public function post(Request $request, UserPasswordHasherInterface $passwordHasher): Response
    {
        $user = new User();
        $user->setPassword(
            $passwordHasher->hashPassword($user,
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
    public function edit(Request $request, $id, UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $user->setPassword(
            $passwordHasher->hashPassword($user,
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
    public function delete(Request $request, $id, UserPasswordHasherInterface $passwordHasher): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/form/edit/{id}', name: 'app_form_edit')]
    public function form_edit($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager->getRepository(User::class)->find($id);
        return $this->render('administrationForm.html.twig', [
            'controller_name' => 'AdminController',
            'user' => $user
        ]);
    }

    #[Route('/admin/horaire', name: 'app_horaire')]
    public function horaire(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $horaires = $entityManager->getRepository(Horaire::class)->findAll();
        return $this->render('admin/Horaire/horaire.html.twig', [
            'controller_name' => 'AdminController',
            'horaires' => $horaires
        ]);
    }

    #[Route('/admin/horaire/add', name: 'app_horaire_add')]
    public function horaireAdd(): Response
    {
        return $this->render('admin/Horaire/horaireForm.html.twig', [
            'controller_name' => 'AdminController',
            'horaire' => new Horaire(),
        ]);
    }

    #[Route('/admin/horaire/form/edit/{id}', name: 'app_horaire_form_edit')]
    public function horaireFormEdit($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $horaire = $entityManager->getRepository(Horaire::class)->find($id);
        return $this->render('admin/Horaire/horaireForm.html.twig', [
            'controller_name' => 'AdminController',
            'horaire' => $horaire,
        ]);
    }

    #[Route('/admin/horaire/post/{id}', name: 'app_horaire_post')]
    public function horairePost(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        if (isset($id) && $id != 0) {
            $horaire = $entityManager->getRepository(Horaire::class)->find($id);
        } else {
            $horaire = new Horaire();
        }
        $horaire->setHeureDebut($request->request->get("heureDebut"));
        $entityManager->persist($horaire);
        $entityManager->flush();
        return $this->redirectToRoute('app_horaire');
    }

    #[Route('/admin/horaire/edit/{id}', name: 'app_horaire_edit')]
    public function horaireEdit($id, Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $horaire = $entityManager->getRepository(Horaire::class)->find($id);

        $horaire->setHeureDebut($request->request->get("heureDebut"));
        $entityManager->persist($horaire);
        $entityManager->flush();
        return $this->redirectToRoute('app_horaire');
    }

    #[Route('/admin/horaire/delete/{id}', name: 'app_horaire_delete')]
    public function horaireDelete($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $horaire = $entityManager->getRepository(Horaire::class)->find($id);
        $entityManager->remove($horaire);
        $entityManager->flush();
        return $this->redirectToRoute('app_horaire');
    }

    #[Route('/admin/gallerie', name: 'app_gallerie')]
    public function gallerie(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $galleries = $entityManager->getRepository(gallerie::class)->findAll();
        return $this->render('admin/gallerie/gallerie.html.twig', [
            'controller_name' => 'AdminController',
            'galleries' => $galleries
        ]);
    }

    #[Route('/admin/gallerie/add/{id}', name: 'app_gallerie_add')]
    public function gallerieAdd(Request $request, ParameterBagInterface $params, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        if (isset($id) && $id != 0) {
            $gallerie = $entityManager->getRepository(Gallerie::class)->find($id);
        } else {
            $gallerie = new Gallerie();
        }

        $form = $this->createForm(ImageType::class);
        $form->handleRequest($request);
        $publicDir = $params->get('kernel.project_dir') . '/public';
        chmod($publicDir, 0755);//Donne la permission au dossier
        $imageDir = $publicDir . '/assets/';
        chmod($imageDir, 0755);
        if (!is_dir($imageDir)) {
            mkdir($imageDir, 0755, true);
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $gallerie->setTitre($request->request->get("titre"));
            $gallerie->setDescription($request->request->get("description"));
            $gallerie->setPrix($request->request->get("prix"));
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                // Move the file to the public directory
                $imageFile->move(
                    $publicDir,
                    $newFilename
                );
                $gallerie->setImage($newFilename);
            }
            $entityManager->persist($gallerie);
            $entityManager->flush();
            return $this->redirectToRoute('app_gallerie');
        }
        return $this->render('admin/gallerie/gallerieForm.html.twig', [
            'controller_name' => 'AdminController',
            'gallerie' => $gallerie,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/gallerie/delete/{id}', name: 'app_gallerie_delete')]
    public function gallerieDelete($id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $gallerie = $entityManager->getRepository(Gallerie::class)->find($id);
        $entityManager->remove($gallerie);
        $entityManager->flush();
        return $this->redirectToRoute('app_gallerie');
    }
}
