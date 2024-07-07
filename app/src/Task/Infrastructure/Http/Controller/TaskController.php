<?php

namespace App\Task\Infrastructure\Http\Controller;

use App\Task\Application\Command\Create\CreateTask;
use App\Task\Application\Command\Delete\DeleteTask;
use App\Task\Application\Command\Update\UpdateTask;
use App\Task\Application\Query\GetUserTasks;
use App\Task\Domain\Request\TaskFilter;
use App\Task\Domain\Request\TaskRequest;
use App\Task\Domain\Response\TaskResponse;
use App\Task\Domain\Task;
use Nelmio\ApiDocBundle\Annotation\Model;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use OpenApi\Attributes as OA;

#[Route('/api/task')]
#[OA\Tag(name: 'Task')]
class TaskController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $bus
    ) {
        $this->messageBus = $bus;
    }

    #[Route('/{id}', name: 'task_get_one', methods: 'GET')]
    #[OA\Response(
        response: 200,
        description: 'Single task response',
        content: new Model(type: TaskResponse::class)
    )]
    public function getOne(
        Task $task,
        #[CurrentUser] $user
    ): JsonResponse
    {
        if ($task->getUser() !== $user) {
            throw $this->createAccessDeniedException();
        }

        return new JsonResponse($task->toResponse()->toArray());
    }

    #[Route(name: 'task_get_users', methods: 'GET')]
    #[OA\Response(
        response: 200,
        description: 'Get list of tasks response',
        content: new OA\JsonContent(type: 'array', items: new OA\Items(ref: new Model(type: TaskResponse::class)))
    )]
    public function getUserTasks(#[MapQueryString] ?TaskFilter $filter): JsonResponse
    {
        $tasks = $this->handle(new GetUserTasks($filter));

        $responseBody = $tasks
            ->map(fn (Task $task) => $task->toResponse()->toArray())
            ->toArray();

        return new JsonResponse($responseBody);
    }

    #[Route(name: 'task_new', methods: 'POST', format: 'json')]
    #[OA\Response(
        response: 201,
        description: 'Created task response',
        content: new Model(type: TaskResponse::class)
    )]
    public function new(#[MapRequestPayload] TaskRequest $request): JsonResponse
    {
        /** @var Task $task */
        $task = $this->handle(new CreateTask($request));

        return new JsonResponse($task->toResponse()->toArray(), Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'task_patch', methods: 'PATCH', format: 'json')]
    #[OA\Response(
        response: 204,
        description: 'Updated task, no response body',
        content: new Model(type: TaskResponse::class)
    )]
    public function patch(
        Task $task,
        #[MapRequestPayload] TaskRequest $request
    ): JsonResponse
    {
        $this->handle(new UpdateTask($task, $request));

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }

    #[Route('/{id}', name: 'task_delete', methods: 'DELETE')]
    #[OA\Response(
        response: 204,
        description: 'Delete task, no response body',
        content: new Model(type: TaskResponse::class)
    )]
    public function delete(Task $task): JsonResponse
    {
        $this->handle(new DeleteTask($task));

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}