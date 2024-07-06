<?php

namespace App\Category\Application\Command\Update;

use App\Category\Application\Command\Create\CreateCategory;
use App\Category\Application\Query\GetAllCategories;
use App\Category\Domain\Category;
use App\Category\Domain\CategoryRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UpdateCategoryHandler
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    public function __invoke(UpdateCategory $message): void
    {
        $categoryRequest = $message->getCategoryRequest();
        $message->getCategory()
            ->setName($categoryRequest->getName());

        $this->em->flush();
    }
}
