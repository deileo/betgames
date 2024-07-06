<?php

namespace App\User\Application\Command\Query;

readonly class GetUser
{
    public function __construct(
        private string $email
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}