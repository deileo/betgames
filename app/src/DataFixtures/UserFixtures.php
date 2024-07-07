<?php

namespace App\DataFixtures;

use App\User\Domain\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public static array $usersMap = [
        [
            'email' => 'luke@betgames.com',
            'password' => 'password',
            'name' => 'Luke Skywalker'
        ],
        [
            'email' => 'yoda@betgames.com',
            'password' => 'password',
            'name' => 'Yoda Lastname'
        ],
        [
            'email' => 'darth@betgames.com',
            'password' => 'password',
            'name' => 'Darth Vader'
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::$usersMap as $userData) {
            $user = (new User());
            $user->setEmail($userData['email'])
                ->setFullName($userData['name'])
                ->setPassword($this->passwordHasher->hashPassword($user, $userData['password']));

            $manager->persist($user);
            $this->addReference($userData['email'], $user);
        }

        $manager->flush();
    }
}
