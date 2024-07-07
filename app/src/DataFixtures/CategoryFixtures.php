<?php

namespace App\DataFixtures;

use App\Category\Domain\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public static array $categoriesMap = [
        [
            'name' => 'Work',
        ],
        [
            'name' => 'Family',
        ],
        [
            'name' => 'Household',
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::$categoriesMap as $categoryData) {
            $category = (new Category())
                ->setName($categoryData['name']);

            $manager->persist($category);
            $this->addReference($categoryData['name'], $category);
        }

        $manager->flush();
    }
}
