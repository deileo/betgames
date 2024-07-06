<?php

namespace App\Task\Domain\Response;

use App\Task\Domain\Enum\Priority;
use App\Task\Domain\Enum\Status;
use DateTime;

readonly class TaskResponse
{
    public function __construct(
        private int $id,
        private string $title,
        private DateTime $dueDate,
        private Status $status,
        private Priority $priority,
        private string $createdBy,
        private ?string $description = null,
        private ?string $categoryName = null
    ) {
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDueDate(): DateTime
    {
        return $this->dueDate;
    }

    public function getCreatedBy(): string
    {
        return $this->createdBy;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    public function getCategoryName(): ?string
    {
        return $this->categoryName;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'dueDate' => $this->dueDate->format('Y-m-d'),
            'status' => $this->getStatus(),
            'priority' => $this->getPriority(),
            'category' => $this->getCategoryName(),
            'createdBy' => $this->getCreatedBy(),
        ];
    }
}