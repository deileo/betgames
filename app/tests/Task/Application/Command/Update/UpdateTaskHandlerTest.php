<?php

namespace App\Tests\Task\Application\Command\Update;

use App\Category\Domain\Category;
use App\Category\Domain\CategoryRepositoryInterface;
use App\Task\Application\Command\Create\CreateTaskHandler;
use App\Task\Application\Command\Update\UpdateTask;
use App\Task\Application\Command\Update\UpdateTaskHandler;
use App\Task\Domain\Enum\Priority;
use App\Task\Domain\Enum\Status;
use App\Task\Domain\Excpetion\TaskActionForbiddenException;
use App\Task\Domain\Request\TaskRequest;
use App\Task\Domain\Task;
use App\User\Domain\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;

class UpdateTaskHandlerTest extends TestCase
{
    private EntityManagerInterface&MockObject $entityManager;
    private Security&MockObject $security;
    private CategoryRepositoryInterface&MockObject $categoryRepository;
    private UpdateTaskHandler $handler;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->security = $this->createMock(Security::class);
        $this->categoryRepository = $this->createMock(CategoryRepositoryInterface::class);

        $this->handler = new UpdateTaskHandler($this->entityManager, $this->security, $this->categoryRepository);
    }
    public function testTaskUpdate(): void
    {
        $category = (new Category())->setName('Work');
        $user = (new User())->setFullName('Luke Skywalker');

        $task = (new Task())
            ->setTitle('Finish tests')
            ->setDescription('Need to finish these tests')
            ->setCategory($category)
            ->setUser($user)
            ->setPriority(Priority::HIGH)
            ->setStatus(Status::IN_PROGRESS)
            ->setDueDate(new DateTime('2024-07-07'));

        $taskRequest = new TaskRequest(
            'Tests Are finished',
            new DateTime('2024-07-07'),
            'Finished tests',
            Status::DONE,
            Priority::HIGH,
            'Work',
        );

        $message = new UpdateTask($task, $taskRequest);

        $this->security
            ->expects($this->once())
            ->method('getUser')
            ->willReturn($user);

        $this->categoryRepository
            ->expects($this->once())
            ->method('getByName')
            ->with('Work')
            ->willReturn($category);

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $this->handler->__invoke($message);
    }

    public function testForbidUpdateForDifferentUser(): void
    {
        $user = (new User())->setFullName('Luke Skywalker');

        $task = (new Task())
            ->setUser($user);

        $taskRequest = new TaskRequest(
            'Tests Are finished',
            new DateTime('2024-07-07'),
            'Finished tests',
            Status::DONE,
            Priority::HIGH,
            'Work',
        );

        $message = new UpdateTask($task, $taskRequest);

        $this->security
            ->expects($this->once())
            ->method('getUser')
            ->willReturn(new User());

        $this->expectException(TaskActionForbiddenException::class);

        $this->entityManager
            ->expects($this->never())
            ->method('flush');

        $this->handler->__invoke($message);
    }
}
