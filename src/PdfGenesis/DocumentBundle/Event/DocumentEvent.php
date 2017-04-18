<?php

namespace PdfGenesis\DocumentBundle\Event;

use PdfGenesis\DocumentBundle\Entity\Document;
use PdfGenesis\DocumentBundle\Entity\Page;
use Symfony\Component\EventDispatcher\Event;

class DocumentEvent extends Event{

    protected $document;

    public function __construct(Document $document){
        $this->document = $document;
    }

    public function getData(){
        return $this->document;
    }

}