<?php


namespace PdfGenesis\ElementBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ElementController extends Controller
{

    public function listAction(Request $request){
        $pageNumber = $request->get('page_number');

        $em = $this->getDoctrine()->getEntityManager();

       if($pageNumber){
           $page = $em->getRepository('PdfGenesisDocumentBundle:Page')->findByPaginationOrder($pageNumber);
           $elements = $em->getRepository('PdfGenesisElementBundle:Element')->findByPage($page);
       }else{
           $elements = $em->getRepository('PdfGenesisElementBundle:Element')->findAll();
       }

       return $this->render('PdfGenesisElementBundle:Element:_list.html.twig',array(
           'elements' => $elements
       ));

    }

}