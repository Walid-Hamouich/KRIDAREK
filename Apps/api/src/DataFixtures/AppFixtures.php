<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\RoleEnum;
use App\Factory\AnnouncementFactory;
use App\Factory\CityFactory;
use App\Factory\PropertyFactory;
use App\Factory\ReviewFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }
    public function load(ObjectManager $manager): void
    {
        AnnouncementFactory::createMany(10);
        ReviewFactory::createMany(5);
        $superAdmin = new User();
        $superAdmin
            ->setEmail('admin@gmail.com')
            ->setFirstName('Mohamed-Amine')
            ->setLastName('Benali')
            ->setBlackListed(false)
            ->setPhoneNum('0639180575')
            ->setRoles([RoleEnum::SUPER_ADMIN->value]);
        $superAdmin->setPassword($this->passwordHasher->hashPassword($superAdmin, '123'));
        $manager->persist($superAdmin);
        $manager->flush();

        $Admin = new User();
        $Admin
            ->setEmail('medobel21@gmail.com')
            ->setFirstName('Mohamed')
            ->setLastName('Belmadani')
            ->setBlackListed(false)
            ->setPhoneNum('0687975143')
            ->setRoles([RoleEnum::ADMIN->value]);
        $Admin->setPassword($this->passwordHasher->hashPassword($Admin, '123'));
        $manager->persist($Admin);
        $manager->flush();
    }
}
