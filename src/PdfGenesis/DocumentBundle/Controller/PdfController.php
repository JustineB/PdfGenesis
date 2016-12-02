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
        try{
            $this->get('knp_snappy.pdf')->generateFromHtml(
                $this->renderView(
                    'PdfGenesisCoreBundle:design:_edit.html.twig'
                ),
                'medias/pdf/file.pdf'
            );

            $this->get('session')->getFlashbag()->add('success','success');


        }catch(Exception $e){

            $this->get('session')->getFlashbag()->add('error','error');
        }



        $response = new BinaryFileResponse('medias/pdf/file.pdf');
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);

        return $response;

//        return $this->redirect($this->generateUrl('design'));
    }

}