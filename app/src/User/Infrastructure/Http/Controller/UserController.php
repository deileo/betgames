<?php

namespace App\User\Infrastructure\Http\Controller;

use App\User\Application\Command\Create\CreateUser;
use App\User\Domain\Request\CreateUserRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user')]
class UserController extends AbstractController
{
    public function __construct(
        private readonly MessageBusInterface $bus
    ) {
    }

    #[Route(name: 'user_get', methods: 'GET')]
    public function get(): JsonResponse
    {
        return new JsonResponse('OK');
    }

    #[Route(name: 'user_new', methods: 'POST', format: 'json')]
    public function new(
        #[MapRequestPayload] CreateUserRequest $request
    ): JsonResponse
    {
        $this->bus->dispatch(new CreateUser($request));

        return new JsonResponse('OK');
    }
}
