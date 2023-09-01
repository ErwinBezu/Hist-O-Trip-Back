<?php

namespace App\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Service\MyMailerService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Exception\NotEncodableValueException;

class ContactController extends AbstractController
{
    /**
     * @Route("/api/contact", name="app_api_contact_post", methods={"POST"})
     */
    public function post(
        Request $request,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        EntityManagerInterface $entityManager,
        MyMailerService $mailer
    ): Response {

        $content = $request->toArray();

        $response = $mailer->send(
            'Message de Histotrip',
            "emails/create_newMessage.html.twig",
            ["lastname" => $content['lastname'],
            "firstname" => $content['firstname'],
            "mail" => $content['mail'],
            "message" => $content['message'],
            "pseudonym" => $content['pseudonym']
            ],
            "maude.meury@oclock.school"
        );

        if ($response) {
            return $this->json('success', Response::HTTP_OK);
        } else {
            return $this->json('failure', Response::HTTP_BAD_REQUEST);

        }


    }
}