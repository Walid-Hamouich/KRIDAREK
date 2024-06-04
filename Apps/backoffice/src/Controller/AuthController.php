<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/auth')]
class AuthController extends AbstractController
{
    #[Route('/login', methods: ["GET", "POST"])]
    public function login(AuthenticationUtils $authenticationUtils, TranslatorInterface $trans): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $email = $authenticationUtils->getLastUsername();
        return $this->render('auth/login.html.twig', [
            "error" => $error,
            "email" => $email
        ]);
    }
}
