<?php

namespace PdfGenesis\DocumentBundle\Factory;

use PdfGenesis\DocumentBundle\Entity\Document;
use PdfGenesis\DocumentBundle\Entity\DocumentInterface;
use PdfGenesis\DocumentBundle\Entity\Page;

class DocumentFactory{

    public static function createDocument(){

        $document = new Document();

        $document->setTitle(DocumentInterface::DEFAULT_TITLE);

        $page = new Page();
        $page->setPaginationOrder(1);

        $document->addPage($page);

        return $document;
    }
}