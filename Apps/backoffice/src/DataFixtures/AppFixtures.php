<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Enum\RoleEnum;
use App\Factory\AnnouncementFactory;
use App\Factory\CityFactory;
use App\Factory\PropertyFactory;
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
        // $product = new Product();
        // $manager->persist($product);
        CityFactory::createMany(2);
        PropertyFactory::createMany(4);
        AnnouncementFactory::createMany(4);
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
    }
}
