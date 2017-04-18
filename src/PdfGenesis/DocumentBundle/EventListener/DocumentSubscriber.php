<?php

namespace PdfGenesis\DocumentBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PdfGenesis\DocumentBundle\Event\DocumentBundleEvents;
use PdfGenesis\DocumentBundle\Event\DocumentEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class DocumentSubscriber implements EventSubscriberInterface
{
    /** @var  EntityManagerInterface $em */
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
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

        $this->em->persist($document);
        $this->em->flush();
    }
}