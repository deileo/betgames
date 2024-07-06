<?php

namespace App\Category\Infrastructure\Http\Controller;

use App\Category\Application\Command\Create\CreateCategory;
use App\Category\Application\Command\Delete\DeleteCategory;
use App\Category\Application\Command\Update\UpdateCategory;
use App\Category\Application\Query\GetAllCategories;
use App\Category\Application\Query\GetCategory;
use App\Category\Domain\Category;
use App\Category\Domain\Request\CategoryRequest;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/category')]
class CategoryController extends AbstractController
{
    use HandleTrait;

    public function __construct(
        MessageBusInterface $bus
    ) {
        $this->messageBus = $bus;
    }

    #[Route(name: 'category_get_all', methods: 'GET')]
    public function getAll(): JsonResponse
    {
        /** @var ArrayCollection<Category> $categories */
        $categories = $this->handle(new GetAllCategories());
        $response = $categories
            ->map(fn (Category $category) => $category->toResponse()->toArray())
            ->toArray();

        return new JsonResponse($response);
    }

    #[Route(name: 'category_new', methods: 'POST', format: 'json')]
    public function new(#[MapRequestPayload] CategoryRequest $request): JsonResponse
    {
        $this->handle(new CreateCategory($request));

        /** @var Category|null $category */
        $category = $this->handle(new GetCategory($request->getName()));

        return new JsonResponse($category?->toResponse()->toArray(), Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'category_patch', methods: 'PATCH', format: 'json')]
    public function patch(
        Category $category,
        #[MapRequestPayload] CategoryRequest $request
    ): JsonResponse
    {
        $this->handle(new UpdateCategory($category, $request));

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }

    #[Route('/{id}', name: 'category_delete', methods: 'DELETE')]
    public function delete(Category $category): JsonResponse
    {
        $this->handle(new DeleteCategory($category));

        return new JsonResponse(status: Response::HTTP_NO_CONTENT);
    }
}
