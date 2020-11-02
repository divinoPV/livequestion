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
        for ($i = 1; $i <= 24; $i++) {
            $user = new User();
            $faker =  Factory::create();
            $username = $faker->firstName;
            $password = Lorem::word();

            $gender = [User::GENDER_MAN, User::GENDER_WOMAN, User::GENDER_NON_BINARY];
            $role = [User::ROLE_USER, User::ROLE_ADMIN, User::ROLE_SUPER_ADMIN];

            $key = rand(0,2);

            $user
                ->addRole($role[$key])
                ->addGender($gender[$key])
                ->setEmail($username."@outlook.com")
                ->setUsername($username)
                ->setImage(Image::imageUrl($width = 640, $height = 480))
                ->setPlainPassword($password);

            $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            var_dump($user->getPlainPassword());

            $manager->persist($user);

            $this->addReference("user-$i", $user);
        }

        $manager->flush();
    }
}
