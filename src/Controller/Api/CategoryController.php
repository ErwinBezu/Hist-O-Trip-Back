<?php

namespace App\Controller\Api;

use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    /**
     * @Route("/api/categories", name="app_api_category_list", methods={"GET"})
     */
    public function list(CategoryRepository $categoryRepository, SerializerInterface $serializer): Response
    {
        $categories = $categoryRepository->findAll();
        
        $response = $serializer->serialize($categories, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['places', 'createdAt', 'updatedAt']]);

        return new JsonResponse($response, Response::HTTP_OK, [], true);
    }
}