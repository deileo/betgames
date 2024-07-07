<?php

namespace App\Tests\Task\Domain;

use App\Category\Domain\Category;
use App\Task\Domain\Enum\Priority;
use App\Task\Domain\Enum\Status;
use App\Task\Domain\Excpetion\TaskActionForbiddenException;
use App\Task\Domain\Task;
use App\User\Domain\User;
use DateTime;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    public function testToResponse(): void
    {
        $user = (new User())->setFullName('Luke Skywalker');
        $category = (new Category())->setName('Work');
        $task = (new Task())
            ->setTitle('Finish tests')
            ->setDescription('Need to finish these tests')
            ->setStatus(Status::IN_PROGRESS)
            ->setPriority(Priority::HIGH)
            ->setDueDate(new DateTime('2024-07-07'))
            ->setUser($user)
            ->setCategory($category)
            ->setCreatedAt(new DateTime('2024-07-07 11:00:00'))
            ->setUpdatedAt(new DateTime('2024-07-07 11:00:00'));

        $taskResponse = $task->toResponse();

        $this->assertEquals('Finish tests', $taskResponse->getTitle());
        $this->assertEquals('Need to finish these tests', $taskResponse->getDescription());
        $this->assertEquals('2024-07-07', $taskResponse->getDueDate()->format('Y-m-d'));
        $this->assertEquals(Status::IN_PROGRESS, $taskResponse->getStatus());
        $this->assertEquals(Priority::HIGH, $taskResponse->getPriority());
        $this->assertEquals('Work', $taskResponse->getCategoryName());
        $this->assertEquals('Luke Skywalker', $taskResponse->getCreatedBy());


        $this->assertEquals([
            'id' => 0,
            'title' => 'Finish tests',
            'description' => 'Need to finish these tests',
            'dueDate' => '2024-07-07',
            'status' => Status::IN_PROGRESS,
            'priority' => Priority::HIGH,
            'category' => 'Work',
            'createdBy' => 'Luke Skywalker',
            'createdAt' => '2024-07-07 11:00:00',
            'updatedAt' => '2024-07-07 11:00:00',
        ], $taskResponse->toArray());
    }

    public function testCanPerformAction(): void
    {
        $user = (new User())->setFullName('Luke Skywalker');
        $task = (new Task())->setUser($user);

        $this->expectException(TaskActionForbiddenException::class);

        $task->canPerformActions(new User());
    }
}
