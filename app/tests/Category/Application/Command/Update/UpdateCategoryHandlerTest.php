<?php

namespace App\Tests\Category\Application\Command\Update;

use App\Category\Application\Command\Update\UpdateCategory;
use App\Category\Application\Command\Update\UpdateCategoryHandler;
use App\Category\Domain\Category;
use App\Category\Domain\Request\CategoryRequest;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UpdateCategoryHandlerTest extends TestCase
{
    private EntityManagerInterface&MockObject $entityManager;
    private Category&MockObject $category;
    private UpdateCategoryHandler $handler;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->category = $this->createMock(Category::class);
        $this->handler = new UpdateCategoryHandler($this->entityManager);
    }

    public function testUpdateCategory(): void
    {
        $message = new UpdateCategory(
            $this->category,
            new CategoryRequest('Work'),
        );

        $this->category
            ->expects($this->once())
            ->method('setName')
            ->with('Work');

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $this->handler->__invoke($message);
    }
}
