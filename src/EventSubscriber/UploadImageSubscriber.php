<?php

namespace App\EventSubscriber;

use ImageKit\ImageKit;
use App\Entity\Picture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityUpdatedEvent;
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
            AfterEntityPersistedEvent::class => ['EntityPersistEvent'],
            AfterEntityUpdatedEvent::class => ['EntityUploadEvent'],
        ];
    }

    public function EntityPersistEvent(AfterEntityPersistedEvent $event)
    {
        $entity = $event->getEntityInstance();

        $this->uploadImage($entity);
    }
    
    public function EntityUploadEvent(AfterEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        $this->uploadImage($entity);
    }

    public function uploadImage($entity)
    {
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