<?php

namespace PdfGenesis\CoreBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use PdfGenesis\CoreBundle\Event\UserBundleEvents;
use PdfGenesis\CoreBundle\Event\UserEvent;
use PdfGenesis\DocumentBundle\Event\DocumentBundleEvents;
use PdfGenesis\DocumentBundle\Event\DocumentEvent;
use PdfGenesis\ElementBundle\Entity\Element;
use PdfGenesis\ElementBundle\Event\ElementBundleEvents;
use PdfGenesis\ElementBundle\Event\ElementEvent;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


class UserSubscriber implements EventSubscriberInterface
{

    use ContainerAwareTrait;

    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getSubscribedEvents()
    {
        // Liste des évènements écoutés et méthodes à appeler
        return array(
            UserBundleEvents::SAVE_USER => array(
                array('sendEmail',10),
                array('save',0)
            )
        );
    }


    public function sendEmail(UserEvent $event){
    }


    public function save(UserEvent $event){
        $user = $event->getData();

        $this->em->persist($user);
        $this->em->flush();

    }





}