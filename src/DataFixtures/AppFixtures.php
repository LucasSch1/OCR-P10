<?php

namespace App\DataFixtures;

use App\Entity\Employe;
use App\Factory\EmployeFactory;
use App\Factory\ProjetFactory;
use App\Factory\TacheFactory;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $hasher
    )
    {}

    public function load(ObjectManager $manager): void
    {
        $employeUser1 = new Employe();
        $employeUser1->setNom('Utilisateur1')
            ->setPrenom('Standard')
            ->setEmail('user@dix.com')
            ->setTypeContrat('CDD')
            ->setPassword($this->hasher->hashPassword($employeUser1, 'user1'))
            ->setDateEntree(new DateTime('2024-09-01'));
        $manager->persist($employeUser1);

        $employeUser2 = new Employe();
        $employeUser2->setNom('Utilisateur2')
            ->setPrenom('Standard')
            ->setEmail('user2@dix.com')
            ->setTypeContrat('CDD')
            ->setPassword($this->hasher->hashPassword($employeUser2, 'user2'))
            ->setDateEntree(new DateTime('2025-09-01'));
        $manager->persist($employeUser2);

        $employeAdmin = new Employe();
        $employeAdmin->setNom('Admin')
            ->setPrenom('Admin')
            ->setEmail('admin@dix.com')
            ->setTypeContrat('CDD')
            ->setPassword($this->hasher->hashPassword($employeAdmin, 'admin'))
            ->setDateEntree(new DateTime('2022-09-01'));
        $manager->persist($employeAdmin);
        $manager->flush();
        ProjetFactory::createMany(3);
        TacheFactory::createMany(10);

    }
}
