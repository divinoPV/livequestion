<?php

namespace App\DataFixtures;

use App\Entity\Question;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Provider\Lorem;
use Exception;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 74; $i++) {
            $question = new Question();

            $j = rand(1,5);
            $g = rand(1,24);

            try {
                $question
                    ->setCategory($this->getReference("category-$j"))
                    ->setUser($this->getReference("user-$g"))
                    ->setCreatedAt(new DateTime())
                    ->setTitle(Lorem::sentence($nbWords = 6, $variableNbWords = true)." ?")
                    ->setVisibility(Question::VISIBILITY_PUBLIC);
            } catch (Exception $e) {
                $e->getMessage();
            }

            $manager->persist($question);

            $this->addReference("question-$i", $question);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            CategoryFixtures::class,
            UserFixtures::Class
        ];
    }
}
