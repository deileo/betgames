<?php

namespace App\Category\Application\Command\Create;

use App\Category\Domain\Request\CategoryRequest;

readonly class CreateCategory
{
    public function __construct(
        private CategoryRequest $categoryRequest
    ) {
    }

    public function getCategoryRequest(): CategoryRequest
    {
        return $this->categoryRequest;
    }
}
