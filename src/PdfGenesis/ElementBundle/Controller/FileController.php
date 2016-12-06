<?php

namespace PdfGenesis\ElementBundle\Controller;

use PdfGenesis\ElementBundle\Entity\File;
use PdfGenesis\ElementBundle\Event\FileEvent;
use PdfGenesis\ElementBundle\Form\ImportType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class FileController extends Controller
{

    public function importAction(Request $request){

        $import = new File();
        $form = $this->createForm(ImportType::class, $import);

        if($form->handleRequest($request)->isSubmitted()){

            $file = $import->getPath();

            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            $file->move( $this->getParameter('files_directory'), $fileName );

            $import->setFile($fileName);
            $import->setPath($this->getParameter('files_directory').$fileName);

            $this->get('event_dispatcher')->dispatch('pdf_genesis.element.create', new FileEvent($import));

            return $this->redirect($this->generateUrl('design'));
        }

        return $this->render('PdfGenesisElementBundle:File:_form.html.twig',array(
            'form' => $form->createView()
        ));
    }

}