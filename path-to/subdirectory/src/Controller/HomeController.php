<?php

namespace App\Controller;

use App\Entity\Gallerie;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class HomeController extends AbstractController
{
    private $security;
    #[Route('/', name: 'app_home')]
    public function index(Security $security): Response
    {
        $this->security= $security;

        $entityManager = $this->getDoctrine()->getManager();
        $gallerie = $entityManager->getRepository(Gallerie::class)->findAll();
        $isAdmin = false;
        if ($this->security->getUser()){
            $isAdmin = $this->security->getUser()->getIsAdmin();

        }

        return $this->render('layouts/home.html.twig', [
            "gallerie"=>$gallerie,
            'isAdmin'=>$isAdmin,
            'user'=>$this->security->getUser()
        ]);
    }
    
}
