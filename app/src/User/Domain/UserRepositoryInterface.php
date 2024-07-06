<?php

namespace App\User\Domain;

interface UserRepositoryInterface
{
    public function getUserByEmail(string $email): ?User;
}