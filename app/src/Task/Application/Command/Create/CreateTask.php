<?php

namespace App\Task\Application\Command\Create;

use App\Task\Domain\Request\TaskRequest;

readonly class CreateTask
{
    public function __construct(
        private TaskRequest $createTaskRequest
    ) {
    }

    public function getCreateTaskRequest(): TaskRequest
    {
        return $this->createTaskRequest;
    }
}
