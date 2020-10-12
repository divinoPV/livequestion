<?php

namespace App\DataFixtures;

use App\Entity\Profil;
use App\Entity\Role;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Exception;
use Faker\Factory;
use Faker\Provider\Image;
use Faker\Provider\Internet;
use Faker\Provider\Lorem;

class ProfilFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $roleUSER = new Role();

        try {
            $roleUSER
                ->setWording("user")
                ->setCode(Role::ROLE_USER);
        } catch (Exception $e) {
            $e->getMessage();
        }

        $roleADMIN = new Role();

        try {
            $roleADMIN
                ->setWording("admin")
                ->setCode(Role::ROLE_ADMIN);
        } catch (Exception $e) {
            $e->getMessage();
        }

        $ROLE = [$roleADMIN, $roleUSER];

        $manager->persist($roleUSER);
        $manager->persist($roleADMIN);

        $GENDER = [Profil::GENDER_MAN, Profil::GENDER_WOMAN, Profil::GENDER_NON_BINARY];

        for($i = 1; $i <= 54; $i++) {
            $profil = new Profil();
            $faker = Factory::create('fr_FR');
            $internet = new Internet($faker);
            $username = $internet->userName();
            $password = Lorem::word();

            shuffle($ROLE);
            shuffle($GENDER);

            try {
                $profil
                    ->setRole($ROLE[0])
                    ->setEmail($username."@outlook.com")
                    ->setImage(Image::imageUrl($width = 640, $height = 480))
                    ->setPlainPassword($password)
                    ->setPassword(password_hash($password, PASSWORD_ARGON2I))
                    ->setUsername($username)
                    ->setGender($GENDER[0]);
            } catch (Exception $e) {
                $e->getMessage();
            }

            $manager->persist($profil);

            $this->addReference("profil$i", (object)$profil);
        }

        $manager->flush();
    }
}
