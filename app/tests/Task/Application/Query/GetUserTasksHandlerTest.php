<?php

namespace App\Tests\Task\Application\Query;

use App\Task\Application\Query\GetUserTasks;
use App\Task\Application\Query\GetUserTasksHandler;
use App\Task\Domain\Enum\Priority;
use App\Task\Domain\Enum\Status;
use App\Task\Domain\Request\TaskFilter;
use App\Task\Domain\Task;
use App\Task\Domain\TaskRepositoryInterface;
use App\User\Domain\User;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;

class GetUserTasksHandlerTest extends TestCase
{
    private TaskRepositoryInterface&MockObject $taskRepository;
    private Security&MockObject $security;
    private GetUserTasksHandler $handler;

    public function setUp(): void
    {
        $this->taskRepository = $this->createMock(TaskRepositoryInterface::class);
        $this->security = $this->createMock(Security::class);

        $this->handler = new GetUserTasksHandler($this->taskRepository, $this->security);
    }

    public function testGetUserTasks(): void
    {
        $filter = new TaskFilter(Status::IN_PROGRESS->value, null, Priority::HIGH->value);
        $user = (new User())->setFullName('Luke Skywalker');

        $task1 = (new Task())
            ->setTitle('Task 1')
            ->setPriority(Priority::HIGH)
            ->setStatus(Status::IN_PROGRESS)
            ->setUser($user);
        $task2 = (new Task())
            ->setTitle('Task 2')
            ->setPriority(Priority::HIGH)
            ->setStatus(Status::IN_PROGRESS)
            ->setUser($user);

        $this->security
            ->expects($this->once())
            ->method('getUser')
            ->willReturn($user);

        $this->taskRepository
            ->expects($this->once())
            ->method('getUserTasks')
            ->with($user, $filter)
            ->willReturn(new ArrayCollection([$task1, $task2]));

        $result = $this->handler->__invoke(new GetUserTasks($filter));

        $this->assertCount(2, $result->toArray());
        $this->assertSame($task1, $result->toArray()[0]);
        $this->assertSame($task2, $result->toArray()[1]);
    }
}
