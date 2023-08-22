<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/api/users/{id}", name="app_api_user_show", methods="GET", requirements={"id"="\d+"})
     */
    public function show(): JsonResponse
    {
        return $this->json('app_api_user_show', Response::HTTP_OK);
    }

        /**
     * @Route("/api/users/signup", name="app_api_user_add", methods="POST")
     */
    public function add(): JsonResponse
    {
        return $this->json('app_api_user_add', Response::HTTP_OK);
    }
}
