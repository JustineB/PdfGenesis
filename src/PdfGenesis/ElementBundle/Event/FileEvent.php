<?php

namespace PdfGenesis\ElementBundle\Event;

use PdfGenesis\ElementBundle\Entity\File;
use Symfony\Component\EventDispatcher\Event;

class FileEvent extends Event
{

    protected $file;


    public function __construct(File $file){
        $this->file = $file;
    }

    public function getData(){
        return $this->file;
    }


}