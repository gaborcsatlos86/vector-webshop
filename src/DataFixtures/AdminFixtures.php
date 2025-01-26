<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;

class AdminFixtures extends Fixture
{
    public const ADMIN_EMAIL = 'csatlos.gabor86@gmail.com';
    public const ADMIN_USER_NAME = 'web-admin';
    
    public function load(ObjectManager $manager): void
    {
        /** @var User $admin */
        $admin = new User();
        $admin->setName('Web Admin');
        $admin->setEmail(self::ADMIN_EMAIL);
        $admin->setUsername(self::ADMIN_USER_NAME);
        $admin->setPlainPassword('DemoLogin678');
        $admin->setAddress('Teszt cím utca 45');
        $admin->setEnabled(true);
        $admin->setSuperAdmin(true);
        
        $manager->persist($admin);

        $manager->flush();
    }
}
