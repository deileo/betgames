<?php

namespace App\Tests\Task\Application\Command\Create;

use App\Category\Domain\Category;
use App\Category\Domain\CategoryRepositoryInterface;
use App\Task\Application\Command\Create\CreateTask;
use App\Task\Application\Command\Create\CreateTaskHandler;
use App\Task\Domain\Enum\Priority;
use App\Task\Domain\Enum\Status;
use App\Task\Domain\Request\TaskRequest;
use App\Task\Domain\Task;
use App\User\Domain\User;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\SecurityBundle\Security;

class CreateTaskHandlerTest extends TestCase
{
    private EntityManagerInterface&MockObject $entityManager;
    private Security&MockObject $security;
    private CategoryRepositoryInterface&MockObject $categoryRepository;
    private CreateTaskHandler $handler;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->security = $this->createMock(Security::class);
        $this->categoryRepository = $this->createMock(CategoryRepositoryInterface::class);

        $this->handler = new CreateTaskHandler($this->entityManager, $this->security, $this->categoryRepository);
    }

    public function testCreateTask(): void
    {
        $category = (new Category())->setName('Work');
        $user = (new User())->setFullName('Luke Skywalker');

        $message = new CreateTask(
            new TaskRequest(
                'Finish tests',
                new DateTime('2024-07-07'),
                'Need to finish these tests',
                Status::IN_PROGRESS,
                Priority::HIGH,
                'Work',
            )
        );

        $this->categoryRepository
            ->expects($this->once())
            ->method('getByName')
            ->with('Work')
            ->willReturn($category);

        $this->security
            ->expects($this->once())
            ->method('getUser')
            ->willReturn($user);

        $this->entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($this->callback(function ($object) {
                $this->assertInstanceOf(Task::class, $object);
                return true;
            }));

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $result = $this->handler->__invoke($message);

        $this->assertEquals('Finish tests', $result->getTitle());
        $this->assertEquals('Need to finish these tests', $result->getDescription());
        $this->assertEquals('2024-07-07', $result->getDueDate()->format('Y-m-d'));
        $this->assertEquals($user, $result->getUser());
        $this->assertEquals(Status::IN_PROGRESS, $result->getStatus());
        $this->assertEquals(Priority::HIGH, $result->getPriority());
    }
}
