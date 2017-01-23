<?php

namespace PdfGenesis\ElementBundle\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use PdfGenesis\ElementBundle\Entity\Element;
use PdfGenesis\ElementBundle\Entity\ElementInterface;
use PdfGenesis\ElementBundle\Entity\Position;
use PdfGenesis\ElementBundle\Entity\Size;
use PdfGenesis\ElementBundle\Event\FileEvent;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class ElementListener
{
    use ContainerAwareTrait;

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
        $page_default = $this->resolveCurrentPage();

        $element->setPosition($position_default);
        $element->setSize($size_default);
        $element->setPage($page_default);


        $this->em->persist($element);
        $this->em->flush();
    }



    /**
     * Has to be move somewhere
     */
    public function resolveCurrentPage(){
        $current_page = null;

        $activate_pages = $this->em->getRepository('PdfGenesisDocumentBundle:Page')->findBy(array('activate' => true));

        if(!$this->container->get('session')->has('document')){
            return $current_page;
        }

        $document_id = $this->container->get('session')->get('document');

        $current_document = $this->em->getRepository('PdfGenesisDocumentBundle:Document')->find($document_id);

        foreach ($activate_pages as $activate_page){
            if(in_array($activate_page, $current_document->getPages()->toArray())){
                $current_page = $activate_page;
                break;
            }
        }

        return $current_page;
    }




}