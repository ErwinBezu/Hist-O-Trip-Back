<?php

namespace App\Controller\Api;

use App\Entity\Tag;
use App\Entity\User;
use App\Entity\Place;
use App\Entity\Century;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\CenturyRepository;
use App\Repository\PlaceRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class PlaceController extends AbstractController
{
    private $token;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->token = $tokenStorage;
    }


    /**
     * @Route("/api/places/categories/{id}", name="app_api_place_category_listByCategories", methods={"GET"}, requirements={"id"="\d+"})
     */
    public function listByCategories(Category $category, PlaceRepository $placeRepository, SerializerInterface $serializer): Response
    {
        $placesByCategory = $placeRepository->findByCategory($category);
        
        $response = $serializer->serialize($placesByCategory, 'json', ['groups' => 'placeWithRelation']);
        
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
    public function list(PlaceRepository $placeRepository, Request $request, SerializerInterface $serializer): Response
    {
        $places = $placeRepository->findAllByTitleSearch($request->get("search"));

        $response = $serializer->serialize($places, 'json', ['groups' => 'placeWithRelation']);

        return new JsonResponse($response, Response::HTTP_OK, [], true);
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
     * @Route("/api/places/add", name="app_api_place_add", methods={"POST"} )
     */
    public function add(
            Request $request, 
            SerializerInterface $serializer, 
            ValidatorInterface $validator, 
            EntityManagerInterface $entityManager, 
            CategoryRepository $categoryRepository,
            CenturyRepository $centuryRepository,
            TagRepository $tagRepository
        ): JsonResponse
    {
        $jsonContent = $request->getContent();
        $user = $this->token->getToken()->getUser();

        try {
            $place = $serializer->deserialize($jsonContent, Place::class, 'json');
        } catch (NotEncodableValueException $e) {
            return $this->json(["error" => "JSON INVALID"], Response::HTTP_BAD_REQUEST);
        }

        // récupération des données non deserializable
        $content = $request->toArray();

        if (array_key_exists('categoriesId', $content)) {
            $categoriesId = $content['categoriesId'];
            foreach ($categoriesId as $categoryId) {
                $place->addCategory($categoryRepository->find($categoryId));
            }
        }

        if (array_key_exists('centuriesId', $content)) {
            $centuriesId = $content['centuriesId'];
            foreach ($centuriesId as $centuryId) {
                $place->addCentury($centuryRepository->find($centuryId));
            }
        }

        if (array_key_exists('tagsId', $content)) {
            $tagsId = $content['tagsId'];
            foreach ($tagsId as $tagId) {
                $place->addTag($tagRepository->find($tagId));
            }
        }

        $errors = $validator->validate($place);

        if (count($errors) > 0) {

            // je crée un nouveau tableau d'erreur
            $dataErrors = [];

            foreach ($errors as $error) {
                // j'injecte dans le tableau à l'index de l'input, les messages d'erreurs qui concernent l'erreur en question
                $dataErrors[$error->getPropertyPath()][] = $error->getMessage();
            }

            // je retourne le json avec mes erreurs
            return $this->json($dataErrors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $place->setUsers($user);  
        // dd($place);
        $entityManager->persist($place);

        $entityManager->flush();

        return $this->json($place, Response::HTTP_CREATED, [
            'location' => $this->generateUrl('app_api_place_show', ['id' => $place->getId()])
        ], [
            'groups' => 'placeWithRelation'
        ]);
    }


}
