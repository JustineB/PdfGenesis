<?php
/**
 * Created by PhpStorm.
 * User: JustBe
 * Date: 18/12/2016
 * Time: 19:23
 */

namespace PdfGenesis\DocumentBundle\Controller;




use PdfGenesis\DocumentBundle\Entity\Document;
use PdfGenesis\DocumentBundle\Entity\Page;
use PdfGenesis\DocumentBundle\Event\DocumentBundleEvents;
use PdfGenesis\DocumentBundle\Event\DocumentEvent;
use PdfGenesis\DocumentBundle\Event\PageEvent;
use PdfGenesis\DocumentBundle\Form\TitleDescriptionForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{

    public function newAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $document = $this->container->get('pdfgenesis.document_manager');

        $em->persist($document);
        $em->flush();

        $this->get('session')->set('document', $document->getId());

        return $this->redirect($this->generateUrl('design'));
    }
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateTitleDescriptionAction(Request $request){
        $em = $this->getDoctrine()->getEntityManager();

        $id = $request->get('id');
        $type = $request->get('type');

        $form = $this->createForm(TitleDescriptionForm::class);

        if($form->handleRequest($request)->isSubmitted()){

            $item = $em->getRepository('PdfGenesisDocumentBundle:'.$type)->find($id);

            if(!$item){
                throw new Exception('This item doesn\'t exist !');
            }

            $title = $form['title']->getData();
            $description = $form['description']->getData();

            $item->setTitle($title);
            $item->setDescription($description);

            $em->persist($item);
            $em->flush();

            return $this->redirect($this->generateUrl('design'));

        }

        return $this->render('PdfGenesisDocumentBundle:Form:_title_description_form.html.twig',array(
            'id' => $id,
            'type' => $type,
            'form' => $form->createView()
        ));
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newPageAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $id = $request->get('id');

        $document = $em->getRepository('PdfGenesisDocumentBundle:Document')->find($id);

        $numberOfPages = sizeof($document->getPages());

        $page = new Page();
        $page->setDocument($document);

        $document->addPage($page);

        $page->setPaginationOrder($numberOfPages+1);

        $this->get('event_dispatcher')->dispatch('pdf_genesis.page.activate', new PageEvent($page));

        return $this->redirect($this->generateUrl('design'));
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changePageAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');
        $value = intval($request->get('change_number'));

        //imagine if you want to jump du 0 à 5

        $document = $em->getRepository('PdfGenesisDocumentBundle:Document')->find($id);

        if(null == $activatePage = $this->getActivatePage($document)){
            throw new Exception('No document created yet !');
        }

        $paginationOrder = $activatePage->getPaginationOrder();
        $changePage = $paginationOrder + $value;

        if($changePage <= 0 || $changePage > sizeof($document->getPages()) ){
            return $this->redirect($this->generateUrl('design'));
        }


        $page = $this->getPage($document, $changePage);

        $this->get('event_dispatcher')->dispatch('pdf_genesis.page.activate', new PageEvent($page));

        return $this->redirect($this->generateUrl('design'));
    }



    /**
     * @param Document $document
     *
     * Mettre cette fonction independante dans un controller
     * @return mixed|null
     */
    public function getActivatePage(Document $document){

        // maybe je peux rejoindre cette fonction et celle d'en bas en jouant sur les "options"
        // sur le repository

        $activatePage = null;

        foreach ($document->getPages() as $page){
            if($page->getActivate()){
                $activatePage = $page;
            }
        }

        return $activatePage;
    }

    /**
     * @param Document $document
     * @param $pageOrderNumber
     * @return mixed|null
     */
    public function getPage(Document $document, $pageOrderNumber){
     // Document used inside the request no ??

        $targetPage = null;

        foreach ($document->getPages() as $page){
            if($page->getPaginationOrder() == $pageOrderNumber){
                $targetPage = $page;
            }
        }

        return $targetPage;
    }


   /* public function saveDocumentAction(Document $document){
        if(null == $user = $this->getUser()){
            //bientôt en ajax
            return $this->redirect($this->generateUrl('design'));
        }

        $event = new DocumentEvent($document);

        $this->container->get("event_dispatcher")->dispatch(DocumentBundleEvents::GENERATE_DOCUMENT, $event);
        $this->container->get("event_dispatcher")->dispatch(DocumentBundleEvents::SAVE_DOCUMENT, $event);

        // trouver une solution pour rendre indé
        return $this->redirect($this->generateUrl('design'));
    }*/

   public function updateViewAjaxAction(Document $document){
       $view = $this->renderView('PdfGenesisDocumentBundle:Document:_update_form.html.twig',array('document' => $document));

       if($view == null){
           return false;
       }

       return new JsonResponse($view);
   }



    /**
     * @return static
     */
    public function saveDocumentAjaxAction(){
        $id_document = $this->get('session')->get('document');

        if(null == $user = $this->getUser() || $id_document == null){
            return JsonResponse::create(false);
        }

        $document = $this->getDoctrine()->getManager()
            ->getRepository('PdfGenesisDocumentBundle:Document')->find($id_document);

        $event = new DocumentEvent($document);

        $this->container->get("event_dispatcher")->dispatch(DocumentBundleEvents::GENERATE_DOCUMENT, $event);
        $this->container->get("event_dispatcher")->dispatch(DocumentBundleEvents::SAVE_DOCUMENT, $event);

        return JsonResponse::create(true);
    }

    /**
     * @param Request $request
     * @return static
     */
    public function dataDocumentAjaxAction(Request $request){
        $id_document = $request->get('id');

        if(null == $user = $this->getUser() || $id_document == null){
            return JsonResponse::create(false);
        }

        $document = $this->getDoctrine()->getManager()
            ->getRepository('PdfGenesisDocumentBundle:Document')->find($id_document);


        $serializedEntity = $this->container->get('jms_serializer')->serialize($document, 'json');

        return new Response($serializedEntity);
    }

}