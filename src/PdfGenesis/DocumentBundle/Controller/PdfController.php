<?php

namespace PdfGenesis\DocumentBundle\Controller;


use PdfGenesis\DocumentBundle\Entity\Document\DocumentImage;
use PdfGenesis\DocumentBundle\Entity\Document\DocumentPDF;
use PdfGenesis\DocumentBundle\Event\DocumentBundleEvents;
use PdfGenesis\DocumentBundle\Event\DocumentEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class PdfController extends Controller
{

    public function generateAction(Request $request){

        //flashbag temporaire changer le nom du doc avec l'user actuel si anonyme dans le fichier des
        // anonyme

        $id = $request->get('id');
        $document = $this->getDoctrine()->getRepository('PdfGenesisDocumentBundle:Document')->find($id);


        $event = new DocumentEvent($document);

        $this->container->get("event_dispatcher")->dispatch(DocumentBundleEvents::GENERATE_DOCUMENT, $event);
        $this->container->get("event_dispatcher")->dispatch(DocumentBundleEvents::SAVE_DOCUMENT, $event);

        $pdf_path = $event->getData()->getDocumentPdf()->getPath();

        $response = new BinaryFileResponse($pdf_path);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        // Le nom ect à jarter !!! differencier

        return $response;

//        return $this->redirect($this->generateUrl('design'));
    }

}