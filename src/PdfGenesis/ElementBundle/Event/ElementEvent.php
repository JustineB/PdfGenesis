<?php

namespace PdfGenesis\ElementBundle\Event;

use PdfGenesis\ElementBundle\Entity\Element;
use PdfGenesis\ElementBundle\Entity\File;
use Symfony\Component\EventDispatcher\Event;

class ElementEvent extends Event
{

    protected $element;


    public function __construct(Element $element){
        $this->element = $element;
    }

    public function getData(){
        return $this->element;
    }


}