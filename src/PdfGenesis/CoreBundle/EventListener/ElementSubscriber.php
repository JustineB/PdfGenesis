<?php

namespace PdfGenesis\CoreBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use PdfGenesis\DocumentBundle\Event\DocumentBundleEvents;
use PdfGenesis\DocumentBundle\Event\DocumentEvent;
use PdfGenesis\ElementBundle\Entity\Element;
use PdfGenesis\ElementBundle\Entity\ElementInterface;
use PdfGenesis\ElementBundle\Entity\File;
use PdfGenesis\ElementBundle\Entity\Position;
use PdfGenesis\ElementBundle\Entity\Size;
use PdfGenesis\ElementBundle\Event\ElementBundleEvents;
use PdfGenesis\ElementBundle\Event\ElementEvent;
use PdfGenesis\ElementBundle\Event\FileEvent;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use PdfGenesis\ElementBundle\EventListener\ElementSubscriber as ElementSubscriberBase;

class ElementSubscriber extends ElementSubscriberBase
{


    public static function getSubscribedEvents()
    {
        // Liste des évènements écoutés et méthodes à appeler
        return array(
            ElementBundleEvents::CREATE_ELEMENT => array(
                array('create',10),
                array('saveDocument',0)
            )
        );
    }


    public function saveDocument(ElementEvent $event){
        /**@var Element $element*/
        $element = $event->getData();

        $document = $element->getPage()->getDocument();

        $event = new DocumentEvent($document);

        $this->container->get("event_dispatcher")->dispatch(DocumentBundleEvents::GENERATE_DOCUMENT, $event);
        $this->container->get("event_dispatcher")->dispatch(DocumentBundleEvents::SAVE_DOCUMENT, $event);

    }





}