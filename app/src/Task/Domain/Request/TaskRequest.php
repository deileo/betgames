<?php

namespace App\Task\Domain\Request;

use App\Task\Domain\Enum\Priority;
use App\Task\Domain\Enum\Status;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

readonly class TaskRequest
{
    #[Assert\NotBlank]
    private string $title;

    private ?string $description;

    #[Assert\NotBlank]
    #[Assert\GreaterThanOrEqual('today')]
    private DateTime $dueDate;

    private ?Status $status;

    private ?Priority $priority;

    private ?string $category;

    public function __construct(
        string $title,
        DateTime $dueDate,
        ?string $description = null,
        ?Status $status = null,
        ?Priority $priority = null,
        ?string $category = null
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->dueDate = $dueDate;
        $this->status = $status;
        $this->priority = $priority;
        $this->category = $category;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getDueDate(): DateTime
    {
        return $this->dueDate;
    }

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function getPriority(): ?Priority
    {
        return $this->priority;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }
}
