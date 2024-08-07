<?php

namespace App\User\Domain\Request;

use App\User\Domain\User;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(fields: ['email'], entityClass: User::class)]
class CreateUserRequest
{
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $email;

    #[Assert\NotBlank]
    private string $fullName;

    #[Assert\NotBlank]
    #[Assert\Length(min: 8, max: 64)]
    private string $password;

    public function __construct(
        ?string $email,
        ?string $fullName,
        ?string $password
    )
    {
        $this->email = $email;
        $this->fullName = $fullName;
        $this->password = $password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getFullName(): string
    {
        return $this->fullName;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
