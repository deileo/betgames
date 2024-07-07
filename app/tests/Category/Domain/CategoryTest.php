<?php

namespace App\Tests\Category\Domain;

use App\Category\Domain\Category;
use App\User\Domain\User;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    public function testToResponse(): void
    {
        $category = (new Category())->setName('Work');

        $categoryResponse = $category->toResponse();

        $this->assertEquals('Work', $categoryResponse->getName());
        $this->assertEquals([
            'id' => 0,
            'name' => 'Work',
        ], $categoryResponse->toArray());
    }
}
