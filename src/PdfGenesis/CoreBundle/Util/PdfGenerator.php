<?php

namespace PdfGenesis\CoreBundle\Util;

use Doctrine\Common\Collections\ArrayCollection;
use PdfGenesis\DocumentBundle\Entity\Document;
use PdfGenesis\DocumentBundle\Entity\Document\DocumentImage;
use PdfGenesis\DocumentBundle\Entity\Document\DocumentPDF;
use PdfGenesis\DocumentBundle\Entity\Page;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Serializer\Exception\Exception;

class PdfGenerator
{
    Use ContainerAwareTrait;

    protected static $options = [
        'margin-top' => 0,
        'margin-right' => 0,
        'margin-bottom' => 0,
        'margin-left' => 0,
        'disable-smart-shrinking' => true,
    ];

    protected static $options_img = [
        'images' => true,
        'disable-smart-width' => true,
        "height" => "1100",
        "width"=> "1024",
    ];

    /** @var TokenStorage $tokenStorage */
    protected $tokenStorage;

    public function __construct( TokenStorage $tokenStorage){
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Document $document
     * @param array $path
     * @return bool
     */
    public function pdfGenerate(Document $document, $path = array())
    {
        if(count($path) <= 0){
            return false;
        }

        try {
            $snappy = $this->container->get('knp_snappy.pdf');

            foreach (self::$options as $margin => $value) {
                $snappy->setOption($margin, $value);
            }

            $view = $this->container->get('templating')->render('PdfGenesisCoreBundle:Design:_pdf_document.html.twig', array('pages' => $document->getPages()));

            $snappy->generateFromHtml($view, $path['pdf']['extension'] . $path['pdf']['name']);


            if (null != $user = $this->tokenStorage->getToken()->getUser()) {
                $documentPDF = $this->container->get('pdf_genesis.file_updater')->updateFile($path['pdf']['name'], new DocumentPDF(), 'pdf/');
                
                $document->setDocumentPdf($documentPDF);
            }

        } catch (Exception $e) {
            return false;
        }

        return true;
    }


    public function ImgGenerate($page,$path){
        if(count($path) <= 0){
            return false;
        }


        try{
            $snappy_image = $this->container->get('knp_snappy.image');

            foreach (self::$options_img as $key => $value) {
                $snappy_image->setOption($key, $value);
            }
            if($page instanceof Document){
                $view = $this->container->get('templating')->render('PdfGenesisCoreBundle:Design:_pdf_document.html.twig', array('pages' => $page->getPages()));
                $object = new DocumentImage();
                $path_file = 'pdf/img/';
            }elseif($page instanceof Page){

                $view = $this->container->get('templating')->render('PdfGenesisCoreBundle:Design:_pdf_document.html.twig', array('pages' => array($page)));
                $object = $page;
                $path_file = "doc".$page->getDocument()->getId()."/pages/img/";
            }else{
                return false;
            }



            $snappy_image->generateFromHtml($view, $path['img']['extension'] . $path['img']['name']);
            $image = $this->container->get('pdf_genesis.file_updater')->updateFile($path['img']['name'], $object, $path_file );


            if($page instanceof Document){
                $page->setDocumentImg($image);
            }
        }catch(FileException $e){
            return false;
        }

        return true;
    }
}