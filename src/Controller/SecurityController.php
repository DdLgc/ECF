<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods:"GET|POST" )]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUserName = $authenticationUtils->getLastUsername();
        return $this->render('login/index.html.twig', [
            "controller_name"=>"LoginController",
            "last_username"=>$lastUserName,
            "error"=>$error
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods:"GET")]
    public function logout()
    {
        // return $this->render('Security/logout.html.twig');
    }
}
