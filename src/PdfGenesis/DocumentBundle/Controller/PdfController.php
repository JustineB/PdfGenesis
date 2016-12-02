<?php

namespace PdfGenesis\DocumentBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;

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

        return $this->redirect($this->generateUrl('design'));
    }

}