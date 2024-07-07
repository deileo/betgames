<?php

namespace App\Tests\Category\Application\Query;

use App\Category\Application\Query\GetCategory;
use App\Category\Application\Query\GetCategoryHandler;
use App\Category\Domain\Category;
use App\Category\Domain\CategoryRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetCategoryHandlerTest extends TestCase
{
    private CategoryRepositoryInterface&MockObject $categoryRepository;
    private GetCategoryHandler $handler;

    public function setUp(): void
    {
        $this->categoryRepository = $this->createMock(CategoryRepositoryInterface::class);
        $this->handler = new GetCategoryHandler($this->categoryRepository);
    }

    public function testGetCategoryByName(): void
    {
        $category = (new Category())
            ->setName('Work');

        $this->categoryRepository
            ->expects($this->once())
            ->method('getByName')
            ->with('Work')
            ->willReturn($category);

        $this->assertSame($category, $this->handler->__invoke(new GetCategory('Work')));
    }
}
