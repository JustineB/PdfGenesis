<?php

namespace PdfGenesis\CoreBundle\Controller;

use PdfGenesis\DocumentBundle\Entity\Document;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PdfGenesisCoreBundle:Homepage:index.html.twig');
    }


    public function designAction(Request $request)
    {
        $em = $this->getDoctrine()->getEntityManager();
        $documentId = $request->get('id_document');

        if(null == $documentId && $this->get('security.authorization_checker')->isGranted('ROLE_USER')){
            // proposez de reprendre un projet ou d'en créer un autre
        }


        if($documentId != null || !$this->get('session')->has('document')){

            if($documentId == null){
                $document = $this->container->get('pdfgenesis.document_manager');
                $em->persist($document);
                $em->flush();

                $documentId = $document->getId();
            }

            $this->get('session')->set('document',$documentId );
        }


        $documentId = $this->get('session')->get('document');

        $document = $em->getRepository('PdfGenesisDocumentBundle:Document')->find($documentId);

        return $this->render('PdfGenesisCoreBundle:Design:index.html.twig', array(
            'document' => $document,
        ));
    }


}
