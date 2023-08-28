<?php

namespace App\Controller\Api;

use App\Repository\CenturyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CenturyController extends AbstractController
{
    /**
     * @Route("/api/centuries", name="app_api_century_list", methods={"GET"})
     */
    public function list(CenturyRepository $centuryRepository, SerializerInterface $serializer): Response
    {
        $centuries = $centuryRepository->findAll();
        
        $response = $serializer->serialize($centuries, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['places', 'createdAt', 'updatedAt']]);

        return new JsonResponse($response, Response::HTTP_OK, [], true);
    }
}
