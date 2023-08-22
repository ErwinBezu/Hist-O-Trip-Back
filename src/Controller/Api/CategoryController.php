<?php

namespace App\Controller\Api;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/api/categories", name="app_api_category_list", methods={"GET"})
     */
    public function list(CategoryRepository $categoryRepository): JsonResponse
    {
    
        return $this->json('app_api_category_list', Response::HTTP_OK);
    }




}
