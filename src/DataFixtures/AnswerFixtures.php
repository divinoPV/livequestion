<?php

namespace App\DataFixtures;

use App\Entity\Answer;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Provider\Lorem;

class AnswerFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 69; $i++) {
            $answer = new Answer();

            $g = rand(1,74);
            $j = rand(1,24);

            $answer
                ->setQuestion($this->getReference("question-$g"))
                ->setUser($this->getReference("user-$j"))
                ->setContent(Lorem::sentence(rand(4,12)))
                ->setCreatedAt(new DateTime());

            $manager->persist($answer);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            QuestionFixtures::class,
            UserFixtures::Class
        ];
    }
}
