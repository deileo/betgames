<?php

namespace App\Tests\User\Domain;

use App\User\Domain\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testToResponse(): void
    {
        $user = (new User())
            ->setEmail('test@betgames.com')
            ->setFullName('Luke skywalker');

        $userResponse = $user->toResponse();

        $this->assertEquals('test@betgames.com', $userResponse->getEmail());
        $this->assertEquals('Luke skywalker', $userResponse->getFullName());
        $this->assertEquals([
            'id' => 0,
            'email' => 'test@betgames.com',
            'fullName' => 'Luke skywalker',
        ], $userResponse->toArray());
    }
}
