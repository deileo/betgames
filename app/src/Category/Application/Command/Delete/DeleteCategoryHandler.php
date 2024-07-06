<?php

namespace App\Category\Application\Command\Delete;

use App\Category\Application\Command\Create\CreateCategory;
use App\Category\Application\Query\GetAllCategories;
use App\Category\Domain\Category;
use App\Category\Domain\CategoryRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class DeleteCategoryHandler
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    public function __invoke(DeleteCategory $message): void
    {
        $category = $message->getCategory();

        $this->em->remove($category);
        $this->em->flush();
    }
}
