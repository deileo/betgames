<?php

namespace App\Task\Domain\Request;

readonly class TaskFilter
{
    public function __construct(
        private ?string $status = null,
        private ?string $category = null,
        private ?string $priority = null
    ) {
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }
}
