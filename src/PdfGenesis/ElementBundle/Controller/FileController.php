<?php

namespace PdfGenesis\ElementBundle\Controller;

use PdfGenesis\ElementBundle\Entity\Element;
use PdfGenesis\ElementBundle\Entity\File;
use PdfGenesis\ElementBundle\Event\ElementBundleEvents;
use PdfGenesis\ElementBundle\Event\ElementEvent;
use PdfGenesis\ElementBundle\Event\FileEvent;
use PdfGenesis\ElementBundle\Form\ImportType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class FileController extends Controller
{

    public function importAction(Request $request){

        $import = new File();
        $element = new Element();
        $form = $this->createForm(ImportType::class, $import);

        if($form->handleRequest($request)->isSubmitted()){

            $file = $import->getPath();

            $import = $this->get('pdf_genesis.file_updater')->updateFile($file,$import, 'elements/');

            $element->setFile($import);

            $this->get('event_dispatcher')->dispatch(ElementBundleEvents::CREATE_ELEMENT, new ElementEvent($element));

            return $this->redirect($this->generateUrl('design'));
        }

        return $this->render('PdfGenesisElementBundle:File:_form.html.twig',array(
            'form' => $form->createView()
        ));
    }

}