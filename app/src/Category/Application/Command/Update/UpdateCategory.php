<?php

namespace App\Category\Application\Command\Update;

use App\Category\Domain\Category;
use App\Category\Domain\Request\CategoryRequest;

readonly class UpdateCategory
{
    public function __construct(
        private Category $category,
        private CategoryRequest $categoryRequest
    ) {
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function getCategoryRequest(): CategoryRequest
    {
        return $this->categoryRequest;
    }
}