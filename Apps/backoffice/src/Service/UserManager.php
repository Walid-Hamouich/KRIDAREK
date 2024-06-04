<?php

namespace App\Service;

use App\Entity\User;
use App\Enum\RoleEnum;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserManager
{
    function __construct(
        private EntityManagerInterface $manager,
        private UserPasswordHasherInterface $passwordHasher,
        private Security $security,
    ) {
    }

    /* 
     *
     * @return User[]
     */
    // function findAll(): array
    // {
    //     /**
    //      * @var UserRepository
    //      */
    //     $userRepository = $this->manager->getRepository(User::class);
    //     return $userRepository->findAllWithoutPassword();
    // }
    /**
     * @return User[]
     */
    function findAll(): array | null
    {
        /**
         * @var User
         */
        $currentUser = $this->security->getUser();
        if ($currentUser == null) return null;
        /**
         * @var UserRepository
         */
        $userRepository = $this->manager->getRepository(User::class);

        return $userRepository->findAllButCurrentUserWithoutPassword($currentUser->getId());
    }

    public function findAllForAdmin()
    {
        /**
         * @var User
         */
        $currentUser = $this->security->getUser();
        if ($currentUser == null) return null;
        /**
         * @var UserRepository
         */
        $userRepository = $this->manager->getRepository(User::class);
        return $userRepository->findAllButCurrentUserWithoutPasswordWithRole(
            $currentUser->getId(),
            RoleEnum::MEMBER->value
        );
    }

    public function countMembers()
    {
        /**
         * @var UserRepository
         */
        $userRepository = $this->manager->getRepository(User::class);
        return $userRepository->countByRole(RoleEnum::MEMBER->value);
    }

    function find(int $id): ?User
    {
        return $this->manager->getRepository(User::class)->find($id);
    }

    function add(User $user)
    {
        $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);
        $this->manager->persist($user);
        $this->manager->flush();
    }

    function update(User $user): void
    {
        $hashedPassword = $this->passwordHasher->hashPassword($user, $user->getPassword());
        $user->setPassword($hashedPassword);
        $this->manager->flush();
    }

    function remove(User $user)
    {
        $this->manager->remove($user);
        $this->manager->flush();
    }

    function ban(User $user)
    {
        $user->setBlackListed(true);
        $this->manager->flush();
    }

    function unban(User $user)
    {
        $user->setBlackListed(false);
        $this->manager->flush();
    }
}
