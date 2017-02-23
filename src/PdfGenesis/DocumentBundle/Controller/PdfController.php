<?php

namespace PdfGenesis\DocumentBundle\Controller;


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

        $pdf_name = 'medias/pdf/file'. time() .'.pdf';


        try{

            $snappy = $this->get('knp_snappy.pdf');

            $options = [
                'margin-top'    => 0,
                'margin-right'  => 0,
                'margin-bottom' => 0,
                'margin-left'   => 0,
            ];

            foreach ($options as $margin => $value) {
                $snappy->setOption($margin, $value);
            }

            $snappy->generateFromHtml(
                $this->renderView(
                    'PdfGenesisCoreBundle:design:_pdf_document.html.twig',
                    array( 'pages' => $document->getPages() )

                ),
                $pdf_name
            );


            $this->get('session')->getFlashbag()->add('success','success');


        }catch(Exception $e){

            $this->get('session')->getFlashbag()->add('error','error');
        }


        $response = new BinaryFileResponse($pdf_name);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);


        // Le nom ect à jarter !!! differencier

        return $response;

//        return $this->redirect($this->generateUrl('design'));
    }

}