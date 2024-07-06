<?php

namespace App\Category\Application\Command\Create;

use App\Category\Application\Query\GetAllCategories;
use App\Category\Domain\Category;
use App\Category\Domain\CategoryRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateCategoryHandler
{
    public function __construct(
        private EntityManagerInterface $em
    ) {
    }

    public function __invoke(CreateCategory $message): void
    {
        $categoryRequest = $message->getCategoryRequest();

        $category = (new Category())
            ->setName($categoryRequest->getName());

        $this->em->persist($category);
        $this->em->flush();
    }
}
