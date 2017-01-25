<?php

namespace PdfGenesis\CoreBundle\Controller;

use PdfGenesis\DocumentBundle\Entity\Document;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PdfGenesisCoreBundle:homepage:index.html.twig');
    }


    public function designAction()
    {
        $em = $this->getDoctrine()->getEntityManager();

        if(!$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_ANONYMOUSLY')){
            // proposez de reprendre un projet ou d'en créer un autre
        }

        if(!$this->get('session')->has('document')){
            $document = $this->container->get('pdfgenesis.document_manager');

            $em->persist($document);
            $em->flush();

            $this->get('session')->set('document', $document->getId());
        }

        $documentId = $this->get('session')->get('document');

        $document = $em->getRepository('PdfGenesisDocumentBundle:Document')->find($documentId);

        return $this->render('PdfGenesisCoreBundle:design:index.html.twig', array(
            'document' => $document
        ));
    }
}
