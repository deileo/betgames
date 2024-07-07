<?php

namespace App\Task\Domain;

use App\Category\Domain\Category;
use App\Task\Domain\Enum\Priority;
use App\Task\Domain\Enum\Status;
use App\Task\Domain\Excpetion\TaskActionForbiddenException;
use App\Task\Domain\Response\TaskResponse;
use App\User\Domain\User;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity]
#[ORM\Table(name: 'tasks')]
#[ORM\Index(name: 'task_priority_idx', columns: ['priority'])]
#[ORM\Index(name: 'task_status_idx', columns: ['status'])]
class Task
{
    Use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id = 0;

    #[ORM\Column]
    private string $title;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'date')]
    private DateTime $dueDate;

    #[ORM\Column(type: 'task_priority', options: ['defaults' => Priority::MEDIUM])]
    private Priority $priority = Priority::MEDIUM;

    #[ORM\Column(type: 'task_status', options: ['defaults' => Status::TODO])]
    private Status $status = Status::TODO;

    #[ORM\ManyToOne(targetEntity: Category::class)]
    #[ORM\JoinColumn(onDelete: 'SET NULL')]
    private ?Category $category = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDueDate(): DateTime
    {
        return $this->dueDate;
    }

    public function setDueDate(DateTime $dueDate): self
    {
        $this->dueDate = $dueDate;

        return $this;
    }

    public function getPriority(): Priority
    {
        return $this->priority;
    }

    public function setPriority(?Priority $priority): self
    {
        $this->priority = $priority ?: Priority::MEDIUM;

        return $this;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status ?: Status::TODO;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function toResponse(): TaskResponse
    {
        return new TaskResponse(
            $this->getId(),
            $this->getTitle(),
            $this->getDueDate(),
            $this->getStatus(),
            $this->getPriority(),
            $this->getUser()->getFullName(),
            $this->getCreatedAt(),
            $this->getUpdatedAt(),
            $this->getDescription(),
            $this->getCategory()?->getName()
        );
    }

    public function canPerformActions(User $user): void
    {
        if ($this->getUser() !== $user) {
            throw new TaskActionForbiddenException();
        }
    }
}
