<?php

namespace PdfGenesis\DocumentBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;

class PdfController extends Controller
{

    public function generateAction(){

        //flashbag temporaire changer le nom du doc avec l'user actuel si anonyme dans le fichier des
        // anonyme

        $pdf_name = 'medias/pdf/file'. time() .'.pdf';



        try{
            $this->get('knp_snappy.pdf')->generateFromHtml(
                $this->renderView(
                    'PdfGenesisCoreBundle:design:_edit.html.twig'
                ),
                $pdf_name
            );

            $this->get('session')->getFlashbag()->add('success','success');


        }catch(Exception $e){

            $this->get('session')->getFlashbag()->add('error','error');
        }


        $response = new BinaryFileResponse($pdf_name);
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;

//        return $this->redirect($this->generateUrl('design'));
    }

}