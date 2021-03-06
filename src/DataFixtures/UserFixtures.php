<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\Image;
use Faker\Provider\Lorem;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $gender = [User::GENDER_MAN, User::GENDER_WOMAN, User::GENDER_NON_BINARY];
        $role = [User::ROLE_USER, User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN];

        for ($i = 1; $i <= 24; $i++) {
            $user = new User();
            $faker =  Factory::create();
            $username = $faker->firstName;
            $pwd = Lorem::word();

            $user
                ->addRole($role[rand(0,count($gender))])
                ->addGender($gender[rand(0,2)])
                ->setEmail($username."@outlook.com")
                ->setUsername($username)
                ->setImage(Image::imageUrl($width = 640, $height = 480))
                ->setPlainPassword($pwd);

            $user->setPassword($this->passwordEncoder
                ->encodePassword(
                    $user,
                    $user->getPlainPassword()
                ));

            $manager->persist($user);

            $this->addReference("user-$i", $user);
        }

        $user2 = new User();
        $pwd2 = "test";

        $user2
            ->addRole($role[2])
            ->addGender($gender[0])
            ->setEmail("test@outlook.com")
            ->setUsername("test")
            ->setImage(Image::imageUrl($width = 640, $height = 480))
            ->setPlainPassword($pwd2);

        $user2->setPassword($this->passwordEncoder
            ->encodePassword(
                $user2,
                $user2->getPlainPassword()
            ));

        $manager->persist($user2);

        $manager->flush();
    }
}
