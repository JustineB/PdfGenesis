<?php
/**
 * Created by PhpStorm.
 * User: JustBe
 * Date: 18/12/2016
 * Time: 19:23
 */

namespace PdfGenesis\DocumentBundle\Controller;




use PdfGenesis\DocumentBundle\Entity\Document;
use PdfGenesis\DocumentBundle\Entity\DocumentInterface;
use PdfGenesis\DocumentBundle\Entity\Page;
use PdfGenesis\DocumentBundle\Event\DocumentBundleEvents;
use PdfGenesis\DocumentBundle\Event\DocumentEvent;
use PdfGenesis\DocumentBundle\Event\PageBundleEvents;
use PdfGenesis\DocumentBundle\Event\PageEvent;
use PdfGenesis\DocumentBundle\Form\TitleDescriptionForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DocumentController extends Controller
{

    /**
     * Créer un nouveau document et génère une nouvelle image du document
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function newAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $document = $this->container->get('pdfgenesis.document_manager');

        $em->persist($document);
        $em->flush();

        $this->container->get("event_dispatcher")->dispatch(PageBundleEvents::NEW_PAGE, new PageEvent($document->getPages()->get(0)));
        $this->container->get("event_dispatcher")->dispatch(DocumentBundleEvents::GENERATE_DOCUMENT, new DocumentEvent($document));


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

        $this->container->get("event_dispatcher")->dispatch(PageBundleEvents::NEW_PAGE, new PageEvent($page));

        return $this->redirect($this->generateUrl('design'));
    }

    /**
     * Action pour changer sa pageau sein d'un document
     *
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function changePageAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $id = $request->get('id');


        $document = $em->getRepository('PdfGenesisDocumentBundle:Document')->find($id);

        if(null == $activatePage = $this->getActivatePage($document)){
            throw new Exception('No document created yet !');
        }

        $paginationOrder = $activatePage->getPaginationOrder();

        if($request->get('change_number')!= null){
            $value = intval($request->get('change_number'));
            $changePage = $paginationOrder + $value;
        }else{
            $changePage = intval($request->get('index_number'));
        }


        if($changePage <= 0 || $changePage > sizeof($document->getPages()) ){
            return $this->redirect($this->generateUrl('design'));
        }


        $page = $this->getPage($document, $changePage);

        $this->container->get("event_dispatcher")->dispatch(PageBundleEvents::ACTIVATE_PAGE, new PageEvent($page));


        return $this->redirect($this->generateUrl('design'));
    }


    /**
     * Récupère la page et l'active
     *
     * @param Request $request
     * @return static
     */
    public function activateAjaxAction(Request $request){
        $id = $request->get('id');

        $page = $this->getDoctrine()->getManager()->getRepository('PdfGenesisDocumentBundle:Page')->find($id);

        if($page){
            $this->container->get("event_dispatcher")->dispatch(PageBundleEvents::ACTIVATE_PAGE, new PageEvent($page));
        }

        $view = $this->renderView('PdfGenesisCoreBundle:Design:_edit.html.twig',array('pages' => array($page), 'document' => $page->getDocument()));

        return JsonResponse::create($view);
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


   public function updateDocumentAjaxAction(Request $request){

       $title = $request->get('title');
       $description = $request->get('description');
       $document_id = $request->get('id');

       $document = $this->getDoctrine()->getManager()->getRepository('PdfGenesisDocumentBundle:Document')->find($document_id);

       if($document_id == null){
           return JsonResponse::create(false);
       }

       $document->setDescription($description);
       $document->setTitle($title);

       $this->container->get("event_dispatcher")->dispatch(DocumentBundleEvents::SAVE_DOCUMENT, new DocumentEvent($document));

       return new JsonResponse(array('id'=> $document_id,'title' =>$title, 'description' => $description ));
   }



    /**
     * Sauvegarde automatiquement le document
     *
     * @return static
     */
    public function saveDocumentAjaxAction(){
        $id_document = $this->get('session')->get('document');


        if( $id_document == null){
            return JsonResponse::create(false);
        }

        $document = $this->getDoctrine()->getManager()
            ->getRepository('PdfGenesisDocumentBundle:Document')->find($id_document);


        $event = new DocumentEvent($document);

        if(null != $user = $this->getUser()){
            $this->container->get("event_dispatcher")->dispatch(DocumentBundleEvents::GENERATE_DOCUMENT, $event);
        }
        $this->container->get("event_dispatcher")->dispatch(DocumentBundleEvents::SAVE_DOCUMENT, $event);


        $page_active = $this->getDoctrine()->getManager()
            ->getRepository('PdfGenesisDocumentBundle:Page')->findOneBy(array('document' => $document, 'activate' => true));

        $this->container->get("event_dispatcher")->dispatch(PageBundleEvents::UPDATE_PAGE, new PageEvent($page_active));


        $view = $this->renderView('PdfGenesisDocumentBundle:Page:_page_element.html.twig',array('page' => $page_active,'loop_index' => $page_active->getPaginationOrder()));

        return JsonResponse::create(array('view' => $view, 'id' => $page_active->getId()));
    }

    /**
     * Récupère les données du document
     *
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

    /**
     * @param Request $request
     * @return static
     */
    public function deleteDocumentAjaxAction(Request $request){
        $id_document = $request->get('id');

        if(null == $user = $this->getUser() || $id_document == null){
            return JsonResponse::create(false);
        }

        $em = $this->getDoctrine()->getManager();

        $document = $em->getRepository('PdfGenesisDocumentBundle:Document')->find($id_document);

        $this->container->get("event_dispatcher")->dispatch(DocumentBundleEvents::CLEAR_DOCUMENT, new DocumentEvent($document));

        $em->remove($document);
        $em->flush();


        return new JsonResponse(array('id'=> $id_document));
    }

}