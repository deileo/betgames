<?php

namespace App\Category\Domain\Request;

use App\Category\Domain\Category;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[UniqueEntity(fields: ['name'], entityClass: Category::class)]
readonly class CategoryRequest
{
    #[Assert\NotBlank]
    private string $name;

    public function __construct(?string $name) {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
