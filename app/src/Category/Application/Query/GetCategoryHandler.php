<?php

namespace App\Category\Application\Query;

use App\Category\Domain\Category;
use App\Category\Domain\CategoryRepositoryInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetCategoryHandler
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository
    ) {
    }

    public function __invoke(GetCategory $message): ?Category
    {
        return $this->categoryRepository->getByName($message->getName());
    }
}
