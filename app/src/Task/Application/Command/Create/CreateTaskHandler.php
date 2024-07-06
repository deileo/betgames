<?php

namespace App\Task\Application\Command\Create;

use App\Category\Domain\CategoryRepositoryInterface;
use App\Task\Domain\Request\TaskRequest;
use App\Task\Domain\Task;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class CreateTaskHandler
{
    public function __construct(
        private EntityManagerInterface $em,
        private Security $security,
        private CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function __invoke(CreateTask $message): Task
    {
        $request = $message->getCreateTaskRequest();
        $task = $this->createTask($request);

        $category = $this->categoryRepository->getByName($request->getCategory());
        $task->setCategory($category);

        $this->em->persist($task);
        $this->em->flush();

        return $task;
    }

    private function createTask(TaskRequest $request): Task
    {
        $task = (new Task())
            ->setTitle($request->getTitle())
            ->setDescription($request->getDescription())
            ->setDueDate($request->getDueDate())
            ->setUser($this->security->getUser());

        if ($request->getStatus()) {
            $task->setStatus($request->getStatus());
        }

        if ($request->getPriority()) {
            $task->setPriority($request->getPriority());
        }

        return $task;
    }
}