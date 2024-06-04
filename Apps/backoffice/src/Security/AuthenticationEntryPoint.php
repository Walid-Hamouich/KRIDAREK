<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{

    function __construct(
        private UrlGeneratorInterface $urlGenerator
    ) {
    }

    function start(Request $request, ?AuthenticationException $authException = null): Response
    {
        $request->getSession()->getFlashBag()->add('danger', 'Vous devez vous connecter pour accéder à cette page.');

        return new RedirectResponse($this->urlGenerator->generate('app_auth_login'));
    }
}
