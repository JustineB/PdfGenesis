<?php
/**
 * Created by PhpStorm.
 * User: gecko
 * Date: 16/04/2017
 * Time: 11:37
 */

namespace PdfGenesis\DocumentBundle\Controller;


use PdfGenesis\CoreBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class LibraryController extends Controller {

    public function indexAction(User $user){
        $library = $user->getLibrary();

        return $this->render('PdfGenesisDocumentBundle:Library:_list.html.twig', array( 'library' => $library));

    }
}