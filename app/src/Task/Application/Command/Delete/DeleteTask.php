<?php

namespace App\Task\Application\Command\Delete;

use App\Task\Domain\Task;

readonly class DeleteTask
{
    public function __construct(
        private Task $task,
    ) {
    }

    public function getTask(): Task
    {
        return $this->task;
    }
}
