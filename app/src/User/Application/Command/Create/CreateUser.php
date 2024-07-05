<?php

namespace App\User\Application\Command\Create;

use App\User\Domain\Request\CreateUserRequest;

readonly class CreateUser
{
    public function __construct(
        private CreateUserRequest $createUserRequest
    ) {
    }

    public function getCreateUserRequest(): CreateUserRequest
    {
        return $this->createUserRequest;
    }
}
