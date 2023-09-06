<?php

namespace App\EventSubscriber;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        // je récupère le requête 
        $request = $event->getRequest();
        // si ma route ne commence pas par api, je fais un early return
        if(strpos($request->getPathInfo(),"/api/")!== 0){
            // ceci est un early return ça permet de couper l'execution de la fonction
            return;
        }
       
       // Récupérer l'exception
        $exception = $event->getThrowable();
        
        // Les cas des erreurs HTTP
        if($exception instanceof HttpException){
            $data = [
                'status' => $exception->getStatusCode(),
                'message' => $exception-> getMessage()
            ];

            $event->setResponse(new JsonResponse($data));
            
           } else {
            $data = [
                'status' => 500, // Le status n'existe pas car ce n'est pas une exception HTTP, donc on met 500 par défaut
                'message' => $exception->getMessage()
            ];

            $event->setResponse(new JsonResponse($data));

           }    
    }
       


    public static function getSubscribedEvents(): array
    {
        return [
            'kernel.exception' => 'onKernelException',
        ];
    }
}
