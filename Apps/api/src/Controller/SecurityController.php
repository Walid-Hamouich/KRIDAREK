<?php

namespace App\Controller;

use Symfony\Component\Routing\Attribute\Route;

#[Route("/api")]
class SecurityController
{

    #[Route("/login", name: 'app_security_login', methods: ['POST'])]
    public function login()
    {
    }
}
