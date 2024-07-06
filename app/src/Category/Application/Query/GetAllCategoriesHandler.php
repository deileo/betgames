<?php

namespace App\Category\Application\Query;

use App\Category\Domain\Category;
use App\Category\Domain\CategoryRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetAllCategoriesHandler
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository
    ) {
    }

    /**
     * @return ArrayCollection<Category>
     */
    public function __invoke(GetAllCategories $message): ArrayCollection
    {
        return $this->categoryRepository->getAll();
    }
}
