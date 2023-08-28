<?php

namespace App\Controller\Api;

use App\Repository\TagRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TagController extends AbstractController
{
    /**
     * @Route("/api/tags", name="app_api_tag_list", methods={"GET"})
     */
    public function list(TagRepository $tagRepository, SerializerInterface $serializer): Response
    {
        $tags = $tagRepository->findAll();
        
        $response = $serializer->serialize($tags, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['places', 'createdAt', 'updatedAt']]);

        return new JsonResponse($response, Response::HTTP_OK, [], true);
    }
}
