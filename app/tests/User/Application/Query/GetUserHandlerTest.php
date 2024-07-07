<?php

namespace App\Tests\User\Application\Query;

use App\User\Application\Query\GetUser;
use App\User\Application\Query\GetUserHandler;
use App\User\Domain\User;
use App\User\Domain\UserRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class GetUserHandlerTest extends TestCase
{
    private UserRepositoryInterface&MockObject $userRepository;
    private GetUserHandler $handler;

    public function setUp(): void
    {
        $this->userRepository = $this->createMock(UserRepositoryInterface::class);
        $this->handler = new GetUserHandler($this->userRepository);
    }
    public function testGetUser(): void
    {
        $user = new User();
        $this->userRepository
            ->expects($this->once())
            ->method('getByEmail')
            ->with('luke@betGames.com')
            ->willReturn($user);

        $this->assertSame($user, $this->handler->__invoke(new GetUser('luke@betGames.com')));
    }
}
