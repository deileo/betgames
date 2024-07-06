<?php

namespace App\Task\Application\Command\Delete;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
readonly class DeleteTaskHandler
{
    public function __construct(
        private EntityManagerInterface $em,
        private Security $security
    ) {
    }

    public function __invoke(DeleteTask $message): void
    {
        $task = $message->getTask();

        $task->canPerformActions($this->security->getUser());

        $this->em->remove($message->getTask());
        $this->em->flush();
    }
}
