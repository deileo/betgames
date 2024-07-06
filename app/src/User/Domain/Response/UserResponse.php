<?php

namespace App\User\Domain\Response;

class UserResponse
{
    public function __construct(
        private int $id,
        private string $email,
        private string $fullName,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'fullName' => $this->fullName,
        ];
    }
}