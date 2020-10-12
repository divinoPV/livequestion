<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Provider\Lorem;
use Exception;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        for($i = 1; $i <= 369; $i++) {
            $answer = new Answer();

            $j = rand(1,54);
            $g = rand(1,158);

            try {
                $answer
                    ->setProfil($this->getReference("profil$j"))
                    ->setQuestion($this->getReference("question$g"))
                    ->setContent(Lorem::sentence(rand(4,24)))
                    ->setCreatedAt(new DateTime());
            } catch (Exception $e) {
                $e->getMessage();
            }

            $manager->persist($answer);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QuestionFixtures::class,
            ProfilFixtures::Class
        ];
    }
}
