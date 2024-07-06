<?php

namespace App\Category\Application\Query;

readonly class GetCategory
{
    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }
}
