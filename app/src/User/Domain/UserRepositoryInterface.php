<?php

namespace App\User\Domain;

interface UserRepositoryInterface
{
    public function getByEmail(string $email): ?User;
}