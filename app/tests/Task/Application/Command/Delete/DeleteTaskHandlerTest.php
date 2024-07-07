<?php

namespace App\Tests\Task\Application\Command\Delete;

use App\Category\Application\Command\Delete\DeleteCategoryHandler;
use App\Task\Application\Command\Delete\DeleteTask;
use App\Task\Application\Command\Delete\DeleteTaskHandler;
use App\Task\Domain\Enum\Priority;
use App\Task\Domain\Enum\Status;
use App\Task\Domain\Excpetion\TaskActionForbiddenException;
use App\Task\Domain\Task;
use App\User\Domain\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;

class DeleteTaskHandlerTest extends TestCase
{
    private EntityManagerInterface&MockObject $entityManager;
    private Security&MockObject $security;
    private DeleteTaskHandler $handler;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->security = $this->createMock(Security::class);

        $this->handler = new DeleteTaskHandler($this->entityManager, $this->security);
    }

    public function testDeleteTask(): void
    {
        $user = (new User())->setFullName('Luke Skywalker');
        $task = (new Task())->setUser($user);

        $this->security
            ->expects($this->once())
            ->method('getUser')
            ->willReturn($user);

        $this->entityManager
            ->expects($this->once())
            ->method('remove')
            ->with($task);

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $this->handler->__invoke(new DeleteTask($task));
    }

    public function testForbidDeleteForDifferentUser(): void
    {
        $user = (new User())->setFullName('Luke Skywalker');
        $task = (new Task())->setUser($user);

        $this->security
            ->expects($this->once())
            ->method('getUser')
            ->willReturn(new User());

        $this->expectException(TaskActionForbiddenException::class);

        $this->entityManager
            ->expects($this->never())
            ->method('remove')
            ->with($task);

        $this->entityManager
            ->expects($this->never())
            ->method('flush');

        $this->handler->__invoke(new DeleteTask($task));
    }
}
