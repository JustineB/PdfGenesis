<?php

namespace PdfGenesis\DocumentBundle\EventListener;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use PdfGenesis\DocumentBundle\Event\DocumentBundleEvents;
use PdfGenesis\DocumentBundle\Event\DocumentEvent;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

class DocumentSubscriber implements EventSubscriberInterface{


    Use ContainerAwareTrait;
    /** @var  EntityManagerInterface $em */
    protected $em;

    /** @var TokenStorage $tokenStorage */
    protected $tokenStorage;

    public function __construct(EntityManagerInterface $em, TokenStorage $tokenStorage)
    {
        $this->em = $em;
        $this->tokenStorage = $tokenStorage;
    }

    public static function getSubscribedEvents()
    {
        // Liste des évènements écoutés et méthodes à appeler
        return array(
            DocumentBundleEvents::SAVE_DOCUMENT => 'saveMethod',
            DocumentBundleEvents::CLEAR_DOCUMENT => 'clearMethod',
            DocumentBundleEvents::GENERATE_DOCUMENT => array(
                array('generateMethod', 0),
                array('clearMethod', 10),
            )
        );
    }

    /**
     * @param DocumentEvent $event
     */
    public function saveMethod(DocumentEvent $event)
    {
        $document = $event->getData();

        if(null != $user =  $this->tokenStorage->getToken()->getUser() ){
            if(!$user->getLibrary()->hasDocument($document)){
                $document->setLibrary($user->getLibrary());
            }
        }

        $this->em->persist($document);
        $this->em->flush();
    }

    /**
     * @param DocumentEvent $event
     * @return DocumentEvent
     */
    public function generateMethod(DocumentEvent $event){
        $document = $event->getData();

        $path = array(
            'pdf' => array(
                'extension' => "medias/pdf/",
                'name'=>'file'. time() .'.pdf'),
            'img' => array(
                'extension'=> "medias/pdf/img/",
                'name'=> 'file'. time() .'.jpg')
        );

        $response = $this->container->get('pdf_genesis.pdf_generator')->pdfGenerate($document, $path);

        if($response == false){
            $this->container->get('session')->getFlashbag()->add('error','error');
        } else{
            $this->container->get('session')->getFlashbag()->add('success','success');
        }

        return new DocumentEvent($document);
    }

    /**
     * @param DocumentEvent $event
     */
    public function clearMethod(DocumentEvent $event){
        $document = $event->getData();


        if($document->getDocumentImg() != null && $document->getDocumentPdf() != null){
            $fichiers = array(
                'path_img' => $document->getDocumentImg()->getPath(),
                'path_pdf' => $document->getDocumentPdf()->getPath(),);

            $this->container->get('pdf_genesis.file_updater')->deleteFile($fichiers);


            $this->em->remove($document->getDocumentImg());
            $this->em->remove($document->getDocumentPdf());

            $document->setDocumentImg(null);
            $document->setDocumentPdf(null);

            $this->em->persist($document);

            $this->em->flush();
        }

    }
}