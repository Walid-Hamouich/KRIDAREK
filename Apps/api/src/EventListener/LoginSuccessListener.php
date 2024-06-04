<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class LoginSuccessListener
{

    public function onLoginSuccess(AuthenticationSuccessEvent $event): void
    {
        $user = $event->getUser();
        $payload = $event->getData();
        if (!$user instanceof User) {
            return;
        }
        if ($user->isBlackListed()) {
            throw new HttpException(
                Response::HTTP_UNAUTHORIZED,
                "Vous êtes banni!"
            );
        }
        // $encoders = [new XmlEncoder(), new JsonEncoder()];
        // $normalizers = [new ObjectNormalizer()];

        // $serializer = new Serializer($normalizers, $encoders);
        // $json = $serializer->serialize($user, 'json');
        // Add information to user payload
        $payload['user'] = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'firstName' => $user->getFirstName(),
            'lastName' => $user->getLastName()
        ];
        $event->setData($payload);
    }
}
