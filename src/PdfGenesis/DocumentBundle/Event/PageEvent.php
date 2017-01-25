<?php

namespace PdfGenesis\DocumentBundle\Event;

use PdfGenesis\DocumentBundle\Entity\Page;
use Symfony\Component\EventDispatcher\Event;

class PageEvent extends Event{

    protected $page;

    public function __construct(Page $page){
        $this->page = $page;
    }

    public function getData(){
        return $this->page;
    }

}