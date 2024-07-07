<?php

namespace App\Tests\Category\Application\Query;

use App\Category\Application\Query\GetAllCategories;
use App\Category\Application\Query\GetAllCategoriesHandler;
use App\Category\Domain\Category;
use App\Category\Domain\CategoryRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetAllCategoriesHandlerTest extends TestCase
{
    private CategoryRepositoryInterface&MockObject $categoryRepository;
    private GetAllCategoriesHandler $handler;

    public function setUp(): void
    {
        $this->categoryRepository = $this->createMock(CategoryRepositoryInterface::class);
        $this->handler = new GetAllCategoriesHandler($this->categoryRepository);
    }

    public function testGetAllCategories(): void
    {
        $category = (new Category())->setName('Work');
        $this->categoryRepository
            ->expects($this->once())
            ->method('getAll')
            ->willReturn(new ArrayCollection([$category]));

        $result = $this->handler->__invoke(new GetAllCategories());

        $this->assertCount(1, $result->toArray());
        $this->assertSame($category, current($result->toArray()));
    }
}
