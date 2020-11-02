<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Provider\Lorem;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 5; $i++)
        {
            $category = new Category();

            $category
                ->setWording(Lorem::word());

            $manager->persist($category);

            $this->addReference("category-$i", $category);
        }

        $manager->flush();
    }
}
