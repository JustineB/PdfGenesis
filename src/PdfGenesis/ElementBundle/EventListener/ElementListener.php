<?php

namespace PdfGenesis\ElementBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use PdfGenesis\ElementBundle\Entity\Element;
use PdfGenesis\ElementBundle\Entity\ElementInterface;
use PdfGenesis\ElementBundle\Entity\Position;
use PdfGenesis\ElementBundle\Entity\Size;
use PdfGenesis\ElementBundle\Event\FileEvent;

class ElementListener
{
    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function create(FileEvent $event){
        $file = $event->getData();

        $element = new Element();

        $element->setFile($file);
        $element->setName(ElementInterface::DEFAULT_NAME);

        //todo
        $position_default = new Position();
        $size_default = new Size();
        $page_default = $this->em->getRepository('PdfGenesisDocumentBundle:Page')->find(1);

        $element->setPosition($position_default);
        $element->setSize($size_default);
        $element->setPage($page_default);


        $this->em->persist($element);
        $this->em->flush();
    }



}