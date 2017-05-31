<?php

namespace PdfGenesis\CoreBundle\Controller;

use PdfGenesis\DocumentBundle\Entity\Document;
use PdfGenesis\DocumentBundle\Event\DocumentBundleEvents;
use PdfGenesis\DocumentBundle\Event\DocumentEvent;
use PdfGenesis\DocumentBundle\Event\PageBundleEvents;
use PdfGenesis\DocumentBundle\Event\PageEvent;
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
        $new = $request->get('new');
        $psdToken = $request->get('mdp_token');

        if(null == $documentId && $this->get('security.authorization_checker')->isGranted('ROLE_USER')){
            // proposez de reprendre un projet ou d'en créer un autre
        }


        if($psdToken != null){
            $this->get('session')->getFlashBag()->add('reset_token',$psdToken);


           /* $uri = $request->getUri();
            $url = strtok($uri, '?');

            return $this->redirect($url);*/
        }

        if($documentId != null || !$this->get('session')->has('document') || $new != null){

            if($documentId == null || $new != null){
                $document = $this->container->get('pdfgenesis.document_manager');
                $em->persist($document);
                $em->flush();

                $this->container->get("event_dispatcher")->dispatch(PageBundleEvents::NEW_PAGE, new PageEvent($document->getPages()->get(0)));
                $this->container->get("event_dispatcher")->dispatch(DocumentBundleEvents::GENERATE_DOCUMENT, new DocumentEvent($document));

                $documentId = $document->getId();
            }

            $this->get('session')->set('document',$documentId );

            return $this->redirect($this->generateUrl('design'));
        }


        $documentId = $this->get('session')->get('document');

        $document = $em->getRepository('PdfGenesisDocumentBundle:Document')->find($documentId);

        return $this->render('PdfGenesisCoreBundle:Design:index.html.twig', array(
            'document' => $document,
        ));
    }


}
