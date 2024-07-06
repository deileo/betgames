<?php

namespace App\User\Application\Query;

use App\User\Domain\User;
use App\User\Domain\UserRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetUserHandler
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function __invoke(GetUser $message): ?User
    {
        $email = $message->getEmail();

        return $this->userRepository->getUserByEmail($email);
    }
}