<?php

namespace App\User\Infrastructure\Http\Controller;

use App\User\Application\Command\Create\CreateUser;
use App\User\Application\Command\Query\GetUser;
use App\User\Domain\Request\CreateUserRequest;
use App\User\Domain\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/api/user')]
class UserController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $bus
    ) {
        $this->messageBus = $bus;
    }

    #[Route(name: 'user_get', methods: 'GET')]
    public function get(#[CurrentUser] User $user): JsonResponse
    {
        return new JsonResponse($user->toResponse()->toArray());
    }

    #[Route(name: 'user_new', methods: 'POST', format: 'json')]
    public function new(#[MapRequestPayload] CreateUserRequest $request): JsonResponse
    {
        $this->handle(new CreateUser($request));

        /** @var User|null $user */
        $user = $this->handle(new GetUser($request->getEmail()));

        return new JsonResponse($user?->toResponse()->toArray(), Response::HTTP_CREATED);
    }
}
