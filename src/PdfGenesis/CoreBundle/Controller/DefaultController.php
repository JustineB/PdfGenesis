<?php

namespace PdfGenesis\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PdfGenesisCoreBundle:homepage:index.html.twig');
    }
}
