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
        private DateTime $createdAt,
        private DateTime $updatedAt,
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

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'dueDate' => $this->getDueDate()->format('Y-m-d'),
            'status' => $this->getStatus(),
            'priority' => $this->getPriority(),
            'category' => $this->getCategoryName(),
            'createdBy' => $this->getCreatedBy(),
            'createdAt' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
            'updatedAt' => $this->getUpdatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}