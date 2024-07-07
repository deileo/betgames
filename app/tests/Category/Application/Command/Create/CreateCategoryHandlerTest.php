<?php

namespace App\Tests\Category\Application\Command\Create;

use App\Category\Application\Command\Create\CreateCategory;
use App\Category\Application\Command\Create\CreateCategoryHandler;
use App\Category\Domain\Category;
use App\Category\Domain\Request\CategoryRequest;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CreateCategoryHandlerTest extends TestCase
{
    private EntityManagerInterface&MockObject $entityManager;
    private CreateCategoryHandler $handler;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->handler = new CreateCategoryHandler($this->entityManager);
    }

    public function testCreateCategory(): void
    {
        $message = new CreateCategory(
            new CategoryRequest('Work'),
        );

        $this->entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($this->callback(function (object $object) {
                $this->assertInstanceOf(Category::class, $object);
                return true;
            }));

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $this->handler->__invoke($message);
    }
}
