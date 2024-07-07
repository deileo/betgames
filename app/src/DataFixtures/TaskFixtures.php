<?php

namespace App\DataFixtures;

use App\Task\Domain\Enum\Priority;
use App\Task\Domain\Enum\Status;
use App\Task\Domain\Task;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class TaskFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create();

        $lukeTasks = [
            [
                'title' => $faker->words(asText: true),
                'description' => $faker->text,
                'dueDate' => $faker->dateTimeBetween('+0 days', '+2 months'),
                'category' => $this->getReference('Work'),
                'createdBy' => $this->getReference('luke@betgames.com'),
                'priority' => Priority::MEDIUM,
                'status' => Status::TODO,
            ],
            [
                'title' => $faker->words(asText: true),
                'description' => $faker->text,
                'dueDate' => $faker->dateTimeBetween('+0 days', '+2 months'),
                'category' => $this->getReference('Work'),
                'createdBy' => $this->getReference('luke@betgames.com'),
                'priority' => Priority::HIGH,
                'status' => Status::IN_PROGRESS,
            ],
            [
                'title' => $faker->words(asText: true),
                'description' => $faker->text,
                'dueDate' => $faker->dateTimeBetween('+0 days', '+2 months'),
                'category' => $this->getReference('Family'),
                'createdBy' => $this->getReference('luke@betgames.com'),
                'priority' => Priority::HIGH,
                'status' => Status::DONE,
            ],
            [
                'title' => $faker->words(asText: true),
                'description' => $faker->text,
                'dueDate' => $faker->dateTimeBetween('+0 days', '+2 months'),
                'category' => $this->getReference('Household'),
                'createdBy' => $this->getReference('luke@betgames.com'),
                'priority' => Priority::HIGH,
                'status' => Status::DONE,
            ]
        ];

        $yodaTasks = [
            [
                'title' => $faker->words(asText: true),
                'description' => $faker->text,
                'dueDate' => $faker->dateTimeBetween('+0 days', '+2 months'),
                'category' => $this->getReference('Household'),
                'createdBy' => $this->getReference('yoda@betgames.com'),
                'priority' => Priority::LOW,
                'status' => Status::TODO,
            ],
            [
                'title' => $faker->words(asText: true),
                'description' => $faker->text,
                'dueDate' => $faker->dateTimeBetween('+0 days', '+2 months'),
                'category' => $this->getReference('Household'),
                'createdBy' => $this->getReference('yoda@betgames.com'),
                'priority' => Priority::HIGH,
                'status' => Status::IN_PROGRESS,
            ],
        ];

        $darthTasks = [
            [
                'title' => $faker->words(asText: true),
                'description' => $faker->text,
                'dueDate' => $faker->dateTimeBetween('+0 days', '+2 months'),
                'category' => $this->getReference('Work'),
                'createdBy' => $this->getReference('darth@betgames.com'),
                'priority' => Priority::HIGH,
                'status' => Status::TODO,
            ],
            [
                'title' => $faker->words(asText: true),
                'description' => $faker->text,
                'dueDate' => $faker->dateTimeBetween('+0 days', '+2 months'),
                'category' => $this->getReference('Work'),
                'createdBy' => $this->getReference('darth@betgames.com'),
                'priority' => Priority::HIGH,
                'status' => Status::IN_PROGRESS,
            ],
            [
                'title' => $faker->words(asText: true),
                'description' => $faker->text,
                'dueDate' => $faker->dateTimeBetween('+0 days', '+2 months'),
                'category' => $this->getReference('Work'),
                'createdBy' => $this->getReference('darth@betgames.com'),
                'priority' => Priority::HIGH,
                'status' => Status::IN_PROGRESS,
            ],
            [
                'title' => $faker->words(asText: true),
                'description' => $faker->text,
                'dueDate' => $faker->dateTimeBetween('+0 days', '+2 months'),
                'category' => $this->getReference('Work'),
                'createdBy' => $this->getReference('darth@betgames.com'),
                'priority' => Priority::HIGH,
                'status' => Status::DONE,
            ],
            [
                'title' => $faker->words(asText: true),
                'description' => $faker->text,
                'dueDate' => $faker->dateTimeBetween('+0 days', '+2 months'),
                'category' => $this->getReference('Work'),
                'createdBy' => $this->getReference('darth@betgames.com'),
                'priority' => Priority::MEDIUM,
                'status' => Status::DONE,
            ],
        ];


        foreach (array_merge($lukeTasks, $yodaTasks, $darthTasks) as $taskData) {
            $task = (new Task())
                ->setTitle($taskData['title'])
                ->setDescription($taskData['description'])
                ->setDueDate($taskData['dueDate'])
                ->setCategory($taskData['category'])
                ->setUser($taskData['createdBy'])
                ->setPriority($taskData['priority'])
                ->setStatus($taskData['status']);

            $manager->persist($task);
        }

        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            CategoryFixtures::class,
        ];
    }
}
