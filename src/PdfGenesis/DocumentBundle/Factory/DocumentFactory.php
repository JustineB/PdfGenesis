<?php

namespace PdfGenesis\DocumentBundle\Factory;

use PdfGenesis\DocumentBundle\Entity\Document;
use PdfGenesis\DocumentBundle\Entity\DocumentInterface;
use PdfGenesis\DocumentBundle\Entity\Page;
use PdfGenesis\DocumentBundle\Event\PageBundleEvents;
use PdfGenesis\DocumentBundle\Event\PageEvent;

class DocumentFactory{



    public static function createDocument(){

        $document = new Document();

        $document->setTitle(DocumentInterface::DEFAULT_TITLE);

        $page = new Page();

        $page->setDocument($document);
        $page->setPaginationOrder(1);
        $page->setActivate(true);


        $document->addPage($page);

        return $document;
    }

}