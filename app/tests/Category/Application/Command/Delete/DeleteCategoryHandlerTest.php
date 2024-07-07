<?php

namespace App\Tests\Category\Application\Command\Delete;

use App\Category\Application\Command\Delete\DeleteCategory;
use App\Category\Application\Command\Delete\DeleteCategoryHandler;
use App\Category\Domain\Category;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class DeleteCategoryHandlerTest extends TestCase
{
    private EntityManagerInterface&MockObject $entityManager;
    private DeleteCategoryHandler $handler;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->handler = new DeleteCategoryHandler($this->entityManager);
    }
    public function testDeleteCategory(): void
    {
        $category = new Category();

        $this->entityManager
            ->expects($this->once())
            ->method('remove')
            ->with($category);

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $this->handler->__invoke(new DeleteCategory($category));
    }
}
