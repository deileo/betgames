<?php

namespace App\Task\Application\Command\Update;

use App\Task\Domain\Request\TaskRequest;
use App\Task\Domain\Task;

readonly class UpdateTask
{
    public function __construct(
        private Task $task,
        private TaskRequest $request
    ) {
    }

    public function getTask(): Task
    {
        return $this->task;
    }

    public function getRequest(): TaskRequest
    {
        return $this->request;
    }
}
