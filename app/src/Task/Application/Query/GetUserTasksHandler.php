<?php

namespace App\Task\Application\Query;

use App\Task\Domain\Task;
use App\Task\Domain\TaskRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class GetUserTasksHandler
{
    public function __construct(
        private TaskRepositoryInterface $taskRepository,
        private Security $security
    ) {
    }

    /**
     * @return ArrayCollection<Task>
     */
    public function __invoke(GetUserTasks $message): ArrayCollection
    {
        $filter = $message->getFilter();

        return $this->taskRepository->getUserTasks($this->security->getUser(), $filter);
    }
}
