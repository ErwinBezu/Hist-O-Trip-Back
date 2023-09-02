<?php

namespace App\EventSubscriber;

use ImageKit\ImageKit;
use App\Entity\Picture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UploadImageSubscriber implements EventSubscriberInterface
{
    private $credentials;
    protected $parameterBag;
    private $manager;

    public function __construct($credentials, ParameterBagInterface $parameterBag, EntityManagerInterface $manager)
    {
        $this->credentials = $credentials;
        $this->parameterBag = $parameterBag;
        $this->manager = $manager;
    }

    
    public static function getSubscribedEvents()
    {
        return [
            AfterEntityPersistedEvent::class => ['uploadImage'],
        ];
    }

    public function uploadImage(AfterEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if ($entity instanceof Picture) {
            
            $filePath = $this->parameterBag->get('kernel.project_dir').'/public/images/upload/'.$entity->getUrl();
            
            $imageKit = new ImageKit(
                $this->credentials['publicKey'],
                $this->credentials['privateKey'],
                $this->credentials['urlEndpoint'],
            );

            $imageUrl = $imageKit->url([
                'path' => '/'.$entity->getUrl()
            ]);

            $uploadFile = $imageKit->uploadFile([
                "file" => fopen($filePath, "r"),
                "fileName" => $entity->getUrl(),
            ]);
                
            $entity->setUrl($imageUrl);

            $this->manager->persist($entity);
            $this->manager->flush();

            $filesystem = new Filesystem();
            $filesystem->remove($filePath);

        }

        return;
    }

}