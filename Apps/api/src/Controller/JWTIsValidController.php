<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JWTIsValidController extends AbstractController
{

    public function __construct()
    {
    }

    public function __invoke(Request $request)
    {
        $user = $this->getUser();
        if ($user === null) {
            throw new NotFoundHttpException('Pas d\'utilisateur', code: 404);
        }
        return $this->json($user);
    }
}
