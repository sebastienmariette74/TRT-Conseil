<?php

namespace App\DataFixtures;

use App\Entity\Administrator;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AdministratorFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher ){}

    public function load(ObjectManager $manager): void
    {
        $administrator = new Administrator();

        $administrator   
            ->setEmail('admin@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $administrator,
                    'admin'
                )
            );

        $manager->persist($administrator);
        $manager->flush();
    }
}
