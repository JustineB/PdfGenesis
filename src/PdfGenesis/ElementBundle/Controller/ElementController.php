<?php


namespace PdfGenesis\ElementBundle\Controller;

use PdfGenesis\ElementBundle\Entity\Element;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ElementController extends Controller
{

    public function listAction(Request $request){
        $pageId = $request->get('page_id');

        $em = $this->getDoctrine()->getEntityManager();

       if($pageId){
           $page = $em->getRepository('PdfGenesisDocumentBundle:Page')->find($pageId);
           $elements = $em->getRepository('PdfGenesisElementBundle:Element')->findByPage($page);
       }else{
           $elements = $em->getRepository('PdfGenesisElementBundle:Element')->findAll();
       }

       return $this->render('PdfGenesisElementBundle:Element:_list.html.twig',array(
           'elements' => $elements
       ));

    }

    public function classificationAction(Request $request){
        $documentId = $request->get('id');

        $em = $this->getDoctrine()->getEntityManager();

        if($documentId){
            $document = $em->getRepository('PdfGenesisDocumentBundle:Document')->find($documentId);

            $activatePage = null;

            foreach ($document->getPages() as $page){
                if($page->getActivate()){
                    $activatePage = $page;
                }
            }

            if($activatePage !== null){
                $elements = $activatePage->getElements();
            }else{
                $elements = null;
            }

        }else{
            $elements = null;

//            $elements = $em->getRepository('PdfGenesisElementBundle:Element')->findAll();
        }


        return $this->render('PdfGenesisElementBundle:Element:_classification.html.twig',array(
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


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxSizeChangeAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');
        $width = $request->get('width');
        $height = $request->get('height');

        $element = $em->getRepository('PdfGenesisElementBundle:Element')->find($id);

        if(!$element){
            return JsonResponse::create(false);
        }

        $element->getSize()->setWidth($width);
        $element->getSize()->setHeight($height);

        $em->persist($element);
        $em->flush();

        return JsonResponse::create(true);
    }


    /**
     * Voir si on peux pas rassembler les fonctions ajax et faire une sorte de factory
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxNameChangeAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');
        $name = $request->get('name');

        $element = $em->getRepository('PdfGenesisElementBundle:Element')->find($id);

        $element->setName($name);

        $em->persist($element);
        $em->flush();

        return JsonResponse::create(true);
    }

}