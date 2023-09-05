<?php

namespace App\Controller\Api;

use App\Repository\PlaceRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Service\MyMailerService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    /**
     * @Route("/api/contact", name="app_api_contact_post", methods={"POST"})
     */
    public function post(
        Request $request,
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
        );

        if ($response) {
            return $this->json('success', Response::HTTP_OK);
        } else {
            return $this->json('failure', Response::HTTP_BAD_REQUEST);

        }
    }

    /**
     * @Route("/api/requete/{placeId}", name="app_api_contact_postBackOffice")
     */
    public function postBackOffice(MyMailerService $mailer, $placeId, PlaceRepository $placeRepository)
    {
        $place = $placeRepository->find($placeId);

        $content = "Un modérateur a besoin de complément pour le lieu : ".$place->getName()." avec l'id : ".$place->getId();

        $response = $mailer->send(
            'Message du backoffice d\'Histotrip',
            "emails/create_newMessage.html.twig",
            ["lastname" => 'modo',
            "firstname" => 'modo',
            "mail" => 'modo@histotrip.fr',
            "message" => $content,
            "pseudonym" => 'modo'
            ],
        );

        return $this->redirectToRoute('app_admin_index', [], Response::HTTP_SEE_OTHER);
    }
}