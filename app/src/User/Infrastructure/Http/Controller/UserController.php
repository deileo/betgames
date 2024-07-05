<?php

namespace App\User\Infrastructure\Http\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user')]
class UserController extends AbstractController
{
    #[Route(name: 'user_get', methods: 'GET')]
    public function get(): JsonResponse
    {
        return new JsonResponse('OK');
    }

    #[Route(name: 'user_new', methods: 'POST')]
    public function new(): JsonResponse
    {
        return new JsonResponse('OK');
    }
}
