<?php

namespace App\Controller\Api;

use App\Entity\User;
use App\Repository\UserRepository;
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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class UserController extends AbstractController
{

    /**
     * @Route("/api/users/{id}", name="app_api_user_show", methods="GET", requirements={"id"="\d+"})
     */
    public function show(User $user, SerializerInterface $serializer): Response
    {
    $response = $serializer->serialize($user, 'json', [AbstractNormalizer::IGNORED_ATTRIBUTES => ['createdAt', 'updatedAt'], 'groups' => 'placeWithRelation']);

        return new JsonResponse($response, Response::HTTP_OK, [], true);
    }    



    /**
     * @Route("/api/users/signup", name="app_api_user_add", methods="POST")
     */
    public function add(UserRepository $userRepository, Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $jsonContent = $request->getContent();

        
        
        try {
            $user = $serializer->deserialize($jsonContent, User::class, 'json');
        } catch (NotEncodableValueException $e) {
            return $this->json(["error" => "JSON INVALID"], Response::HTTP_BAD_REQUEST);
        }
            
        //dd($user);

        $plainPassword = $user->getPassword();
        // Hash
        $passwordHash = $passwordHasher->hashPassword($user,$plainPassword);
        // Set du mot de passe
        $user->setPassword($passwordHash);

        $userRepository->add($user, true);


        // Détection des erreurs
        $errors = $validator->validate($user);

        // Renvoie un json avec les erreurs
        if (count($errors) > 0) {
            $dataErrors = [];

            foreach ($errors as $error) {
            $dataErrors[$error->getPropertyPath()][] = $error->getMessage();
        }

            return $this->json($dataErrors, Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        
            
        $entityManager->persist($user);

        $entityManager->flush();

        return $this->json([$user], Response::HTTP_CREATED, [
            "Location" => $this->generateUrl("app_api_user_show", ["id" => $user->getId()])
        ], [
            "groups" => "add"
        ]);
    }



    /**
     * @Route("/api/users/{id}", name="app_api_user_edit", methods="PUT")
     */
    public function edit(Request $request, SerializerInterface $serializer, ValidatorInterface $validator, EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupération du json en brut
        $jsonContent = $request->getContent();

        //  Transformation du json en entité user

        try {
            $user = $serializer->deserialize($jsonContent, User::class, 'json');
        } catch (NotEncodableValueException $e) {
            return $this->json(["error"=>"JSON INVALID"], Response::HTTP_BAD_REQUEST);
        }

        // Détection des erreurs 
        $errors = $validator->validate($user);

        // Renvoie un json avec les erreurs
        if (count($errors) > 0) {
            $dataErrors = [];

            foreach ($errors as $error){
                $dataErrors[$error->getPropertyPath()][] = $error->getMessage();
            }
                
            return $this->json($dataErrors, Response::HTTP_UNPROCESSABLE_ENTITY);  
        }
        
            //dd($user);
            
        $entityManager->persist($user);

        $entityManager->flush();

        return $this->json([$user], Response::HTTP_CREATED, [
            "Location" => $this->generateUrl("app_api_user_show", ["id" => $user->getId()])
        ], [
            "groups" => "edit"
        ]);

    }
}

