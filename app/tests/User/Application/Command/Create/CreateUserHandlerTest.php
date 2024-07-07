<?php

namespace App\Tests\User\Application\Command\Create;

use App\User\Application\Command\Create\CreateUser;
use App\User\Application\Command\Create\CreateUserHandler;
use App\User\Domain\Request\CreateUserRequest;
use App\User\Domain\User;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class CreateUserHandlerTest extends TestCase
{
    private EntityManagerInterface&MockObject $entityManager;
    private UserPasswordHasherInterface&MockObject $userPasswordHasher;
    private CreateUserHandler $handler;

    public function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->userPasswordHasher = $this->createMock(UserPasswordHasherInterface::class);

        $this->handler = new CreateUserHandler($this->entityManager, $this->userPasswordHasher);
    }

    public function testCreatUser(): void
    {
        $message = new CreateUser(
            new CreateUserRequest('luke@webgames.com', 'Luke Skywalker', 'password'),
        );

        $this->userPasswordHasher
            ->expects($this->once())
            ->method('hashPassword')
            ->with(
                $this->callback(function (object $object) {
                    $this->assertInstanceOf(User::class, $object);
                    return true;
                }),
                'password'
            )
            ->willReturn('hashed_password');

        $this->entityManager
            ->expects($this->once())
            ->method('persist')
            ->with($this->callback(function (object $object) {
                $this->assertInstanceOf(User::class, $object);
                return true;
            }));

        $this->entityManager
            ->expects($this->once())
            ->method('flush');

        $this->handler->__invoke($message);
    }
}
