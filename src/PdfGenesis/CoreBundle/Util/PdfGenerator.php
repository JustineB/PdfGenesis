<?php

namespace PdfGenesis\CoreBundle\Util;

use Doctrine\Common\Collections\ArrayCollection;
use PdfGenesis\DocumentBundle\Entity\Document;
use PdfGenesis\DocumentBundle\Entity\Document\DocumentImage;
use PdfGenesis\DocumentBundle\Entity\Document\DocumentPDF;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Serializer\Exception\Exception;

class PdfGenerator
{
    Use ContainerAwareTrait;



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
            $snappy_image = $this->container->get('knp_snappy.image');

            $options = [
                'margin-top' => 0,
                'margin-right' => 0,
                'margin-bottom' => 0,
                'margin-left' => 0,
            ];

            foreach ($options as $margin => $value) {
                $snappy->setOption($margin, $value);
            }

            $view = $this->container->get('templating')->render('PdfGenesisCoreBundle:Design:_pdf_document.html.twig', array('pages' => $document->getPages()));

            $snappy->generateFromHtml($view, $path['pdf']['extension'] . $path['pdf']['name']);
            $snappy_image->generateFromHtml($view, $path['img']['extension'] . $path['img']['name']);


            if (null != $user = $this->tokenStorage->getToken()->getUser()) {
                $documentPDF = $this->container->get('pdf_genesis.file_updater')->updateFile($path['pdf']['name'], new DocumentPDF(), 'pdf/');
                $documentImage = $this->container->get('pdf_genesis.file_updater')->updateFile($path['img']['name'], new DocumentImage(), 'pdf/img/');
                
                $document->setDocumentPdf($documentPDF);
                $document->setDocumentImg($documentImage);
            }

        } catch (Exception $e) {
            return false;
        }

        return true;
    }

}