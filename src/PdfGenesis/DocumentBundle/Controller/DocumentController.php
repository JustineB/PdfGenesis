<?php
/**
 * Created by PhpStorm.
 * User: JustBe
 * Date: 18/12/2016
 * Time: 19:23
 */

namespace PdfGenesis\DocumentBundle\Controller;




use PdfGenesis\DocumentBundle\Form\TitleDescriptionForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;

class DocumentController extends Controller
{

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

}