<?php

namespace PdfGenesis\DocumentBundle\EventListener;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PdfGenesis\DocumentBundle\Entity\DocumentInterface;
use PdfGenesis\DocumentBundle\Event\DocumentBundleEvents;
use PdfGenesis\DocumentBundle\Event\DocumentEvent;
use PdfGenesis\DocumentBundle\Event\PageBundleEvents;
use PdfGenesis\DocumentBundle\Event\PageEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class PageSubscriber implements EventSubscriberInterface{


    Use ContainerAwareTrait;
    /** @var  EntityManagerInterface $em */
    protected $em;

    /** @var TokenStorage $tokenStorage */
    protected $tokenStorage;

    protected static $index_pages = 0;

    public function __construct(EntityManagerInterface $em, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        // Liste des évènements écoutés et méthodes à appeler
        return array(
            PageBundleEvents::ACTIVATE_PAGE => 'activate',
            PageBundleEvents::UPDATE_PAGE => array(
                array('clearMethod',0),
                array('newMethod',10),
            ),
            PageBundleEvents::NEW_PAGE => array(
                array('clearMethod',10),
                array('newMethod',0),
                array('activate',-10),
            )
        );
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

    /**
     * @param PageEvent $event
     * @return DocumentEvent
     */
    public function newMethod(PageEvent $event){
        $page = $event->getData();

        $path = array(
            'img' => array(
                'extension'=> "medias/doc".$page->getDocument()->getId()."/pages/img/",
                'name'=> 'pages'. time() .'.jpg')
        );

        $this->container->get('pdf_genesis.pdf_generator')->ImgGenerate($page, $path);



        return new PageEvent($page);
    }

    /**
     * @param PageEvent $event
     */
    public function clearMethod(PageEvent $event){
        $page = $event->getData();


        if($page->getPath() != null && $page->getFile() != null){
            $fichiers = array(
                'path_img' => $page->getPath());


            $this->container->get('pdf_genesis.file_updater')->deleteFile($fichiers);


            $page->setPath(null);
            $page->setFile(null);

            $this->em->persist($page);

            $this->em->flush();
        }

    }
}