<?php

namespace PdfGenesis\DocumentBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PdfGenesis\DocumentBundle\Event\DocumentBundleEvents;
use PdfGenesis\DocumentBundle\Event\DocumentEvent;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class DocumentSubscriber implements EventSubscriberInterface{


    /** @var  EntityManagerInterface $em */
    protected $em;

    /** @var TokenStorage $tokenStorage */
    protected $tokenStorage;

    public function __construct(EntityManagerInterface $em, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        // Liste des évènements écoutés et méthodes à appeler
        return array(
            DocumentBundleEvents::SAVE_DOCUMENT => 'saveMethod'
        );
    }

    public function saveMethod(DocumentEvent $event)
    {
        $document = $event->getData();

        if(null != $user =  $this->tokenStorage->getToken()->getUser() ){
            if(!$user->getLibrary()->hasDocument($document)){
                $document->setLibrary($user->getLibrary());
            }
        }

        $this->em->persist($document);
        $this->em->flush();
    }
}