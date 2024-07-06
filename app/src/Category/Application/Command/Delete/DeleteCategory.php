<?php

namespace App\Category\Application\Command\Delete;

use App\Category\Domain\Category;

readonly class DeleteCategory
{
    public function __construct(private Category $category) {
    }

    public function getCategory(): Category
    {
        return $this->category;
    }
}
