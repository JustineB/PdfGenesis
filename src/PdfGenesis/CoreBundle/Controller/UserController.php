<?php
/**
 * Created by PhpStorm.
 * User: gecko
 * Date: 16/04/2017
 * Time: 11:03
 */

namespace PdfGenesis\CoreBundle\Controller;


use PdfGenesis\CoreBundle\Event\UserBundleEvents;
use PdfGenesis\CoreBundle\Event\UserEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller {

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(){
        return $this->render('PdfGenesisCoreBundle:User:index.html.twig');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function getDataAction(){
        if(null == $user = $this->getUser()){
            $this->get('session')->getFlashBag()->add('No_access', 'no access to this zone');
        }

        return $this->render('PdfGenesisCoreBundle:User:_personal_data.html.twig', array(
            'user' => $user
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function getLibraryAction(){
        if(null == $user = $this->getUser()){
            $this->get('session')->getFlashBag()->add('No_access', 'no access to this zone');
            return new Response('no access');
        }

        $response = $this->forward('PdfGenesisDocumentBundle:Library:index', array(
            'id' => $user->getId()
        ));



        return $response;
    }


    public function updateUserAjaxAction(Request $request){
        $email = $request->get('email');
        $user = $this->getUser();

        if( null == $user || null == $email){
            return JsonResponse::create($email);
        }

        $user->setEmail($email);
        $user->setEmailCanonical($email);

        $this->get('event_dispatcher')->dispatch(UserBundleEvents::SAVE_USER, new UserEvent($user));

        return JsonResponse::create(true);
    }

    public function importPictureAction(Request $request){

        $file = $request->files->get('picture-download-input');
        $user = $this->getUser();

        $this->get('event_dispatcher')->dispatch(UserBundleEvents::CLEAR_PICTURE, new UserEvent($user));

        $this->get('pdf_genesis.file_updater')->updateFile($file, $user, 'user/'.$user->getId().'/');

        $this->get('event_dispatcher')->dispatch(UserBundleEvents::SAVE_USER, new UserEvent($user));

        return $this->redirect($this->generateUrl('user_index'));


    }
}