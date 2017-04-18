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

        $pdf_extension = "medias/pdf/";
        $pdf_img_extension = "medias/pdf/img/";

        $pdf_name = 'file'. time() .'.pdf';
        $img_name = 'file'. time() .'.jpg';


        try{

            $snappy = $this->get('knp_snappy.pdf');
            $snappy_image = $this->get('knp_snappy.image');



            $options = [
                'margin-top'    => 0,
                'margin-right'  => 0,
                'margin-bottom' => 0,
                'margin-left'   => 0,
            ];

            foreach ($options as $margin => $value) {
                $snappy->setOption($margin, $value);
            }

            $view = $this->renderView('PdfGenesisCoreBundle:Design:_pdf_document.html.twig',array( 'pages' => $document->getPages() ));

            $snappy->generateFromHtml( $view, $pdf_extension.$pdf_name);
            $snappy_image->generateFromHtml($view, $pdf_img_extension.$img_name);


            if(null != $user = $this->getUser()){
                $documentPDF = $this->get('pdf_genesis.file_updater')->updateFile($pdf_name,new DocumentPDF(), 'pdf/');
                $documentImage = $this->get('pdf_genesis.file_updater')->updateFile($img_name,new DocumentImage(), 'pdf/img/');

                $document->setDocumentPdf($documentPDF);
                $document->setDocumentImg($documentImage);

                $this->get("event_dispatcher")->dispatch(DocumentBundleEvents::SAVE_DOCUMENT, new DocumentEvent($document));
            }

            $this->get('session')->getFlashbag()->add('success','success');


        }catch(Exception $e){

            $this->get('session')->getFlashbag()->add('error','error');
        }


        $response = new BinaryFileResponse($pdf_extension.$pdf_name);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);


        // Le nom ect à jarter !!! differencier

        return $response;

//        return $this->redirect($this->generateUrl('design'));
    }

}