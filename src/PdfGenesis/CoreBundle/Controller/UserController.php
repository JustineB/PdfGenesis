<?php
/**
 * Created by PhpStorm.
 * User: gecko
 * Date: 16/04/2017
 * Time: 11:03
 */

namespace PdfGenesis\CoreBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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

}