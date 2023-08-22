<?php

namespace App\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/api/contact", name="app_api_contact_post", methods={"POST"})
     */
    public function post(Request $request): JsonResponse
    {
        return $this->json('app_api_contact_post', Response::HTTP_OK);
    }
}
