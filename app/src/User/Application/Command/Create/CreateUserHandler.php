<?php

namespace App\User\Application\Command\Create;

use App\User\Domain\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsMessageHandler]
readonly class CreateUserHandler
{
    public function __construct(
        private EntityManagerInterface $em,
        private UserPasswordHasherInterface $passwordHasher,
    ) {
    }

    public function __invoke(CreateUser $message): void
    {
        $body = $message->getCreateUserRequest();

        $user = new User();
        $user->setEmail($body->getEmail())
            ->setPassword($this->passwordHasher->hashPassword($user, $body->getPassword()))
            ->setFullName($body->getFullName());

        $this->em->persist($user);
        $this->em->flush();
    }
}
