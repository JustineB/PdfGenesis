<?php


namespace PdfGenesis\ElementBundle\Controller;

use PdfGenesis\ElementBundle\Entity\Element;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxPositionChangeAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');
        $latitude = $request->get('y');
        $longitude = $request->get('x');

        $element = $em->getRepository('PdfGenesisElementBundle:Element')->find($id);

        if(!$element){
            return JsonResponse::create(false);
        }

        $element->getPosition()->setLatitude($latitude);
        $element->getPosition()->setLongitude($longitude);

        $em->persist($element);
        $em->flush();

        return JsonResponse::create(true);
    }

}