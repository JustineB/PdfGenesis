<?php

namespace PdfGenesis\DocumentBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use PdfGenesis\DocumentBundle\Event\PageEvent;

class PageListener{

    /** @var  EntityManagerInterface $em */
    protected $em;

    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    /**
     * @param PageEvent $event
     *
     * Activate the page as being used.
     */
    public function activate(PageEvent $event){

        $page = $event->getData();

        $documentId = $page->getDocument()->getId();

        $document = $this->em->getRepository('PdfGenesisDocumentBundle:Document')->find($documentId);

        foreach ($document->getPages() as $item){
            $item->setActivate(false);
            $this->em->persist($item);
        }

        $page->setActivate(true);

        $this->em->persist($page);
        $this->em->flush();
    }

}