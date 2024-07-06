<?php

namespace App\Task\Application\Command\Update;

use App\Category\Domain\CategoryRepositoryInterface;
use App\Task\Application\Command\Create\CreateTask;
use App\Task\Domain\Excpetion\TaskActionForbiddenException;
use App\Task\Domain\Request\TaskRequest;
use App\Task\Domain\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class UpdateTaskHandler
{
    public function __construct(
        private EntityManagerInterface $em,
        private Security $security,
        private CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function __invoke(UpdateTask $message): void
    {
        $request = $message->getRequest();
        $task = $message->getTask();

        $task->canPerformActions($this->security->getUser());

        $task
            ->setTitle($request->getTitle())
            ->setStatus($request->getStatus())
            ->setPriority($request->getPriority())
            ->setDueDate($request->getDueDate());

        if ($request->getDescription()) {
            $task->setDescription($request->getDescription());
        }

        $this->handleCategory($request->getCategory(), $task);

        $this->em->flush();
    }

    private function handleCategory(?string $categoryName, Task $task): void
    {
        if (!$categoryName) {
            $task->setCategory(null);

            return;
        }

        $category = $this->categoryRepository->getByName($categoryName);
        $task->setCategory($category);
    }
}
