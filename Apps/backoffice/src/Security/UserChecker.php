<?php

namespace App\Security;

use App\Entity\User;
use App\Enum\RoleEnum;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    public function checkPreAuth(UserInterface $user): void
    {
        if (
            !in_array(RoleEnum::ADMIN->value, $user->getRoles()) &&
            !in_array(RoleEnum::SUPER_ADMIN->value, $user->getRoles())
        ) {
            throw new CustomUserMessageAuthenticationException('Vous n\'avez pas accès');
        }
        if ($user->isBlackListed()) {
            throw new CustomUserMessageAuthenticationException('Vous êtes banni');
        }
    }

    function checkPostAuth(UserInterface $user): void
    {
    }
}
