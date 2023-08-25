<?php

namespace App\Controller\Api;

use App\Entity\Tag;
use App\Entity\Place;
use App\Entity\Century;
use App\Entity\Category;
use App\Repository\PlaceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlaceController extends AbstractController
{
    
    
    /**
     * @Route("/api/places/categories/{id}", name="app_api_place_category_listByCategories", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function listByCategories(Category $category, PlaceRepository $placeRepository, SerializerInterface $serializer): Response
    {
        // dd($category);
        $placesByCategory = $placeRepository->findByCategory($category);
        // dd($placesByCategory);
        $response = $serializer->serialize($placesByCategory, 'json', ['groups' => 'placeWithRelation']);

        // dd($response);
        return new JsonResponse($response, Response::HTTP_OK, [], true);
    }



    /**
     * @Route("/api/places/{id}", name="app_api_place_show", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function show(Place $place, SerializerInterface $serializer):Response
    {
        $response = $serializer->serialize($place, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['createdAt', 'updatedAt'], 'groups' => 'placeWithRelation']);

        return new JsonResponse($response, Response::HTTP_OK, [], true);
    }


    /**
     * @Route("/api/places", name="app_api_place_list", methods={"GET"} )
     */
    public function list(PlaceRepository $placeRepository, Request $request): JsonResponse
    {
        // $place = $placeRepository->findAllByTitleSearch($request->get("search"));


        return $this->json('app_api_place_list', Response::HTTP_OK);
    }


    /**
     * @Route("/api/places/filter", name="app_api_place_filter", methods={"GET"} )
     */
    public function filter(Category $category, Century $century, Tag $tag, Place $place): JsonResponse
    
    {
        // if (!)
        //$places = $filter->getPlaces();
        
        return $this->json('app_api_place_filter', Response::HTTP_OK);
    }

    /**
     * @Route("/api/places/ajouter", name="app_api_place_add", methods={"POST"} )
     */
    public function add(PlaceRepository $PlaceRepository, Request $request): JsonResponse
    {
    
        return $this->json('app_api_place_add', Response::HTTP_OK);
    }


}
