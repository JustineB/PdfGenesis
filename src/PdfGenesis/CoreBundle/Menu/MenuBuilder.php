<?php

namespace PdfGenesis\CoreBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class MenuBuilder implements ContainerAwareInterface{

    use ContainerAwareTrait;

    public function mainMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root',array(
            'childrenAttributes' => array(
                'class' => 'nav navbar-nav'
            )));

        $menu->addChild('concept', array('uri' => '#concept'));
        $menu->addChild('design', array('uri' => '#design'));
        $menu->addChild('login-sign-up', array('uri' => '#'));

        foreach ($menu->getChildren() as $child){
            $label = $this->container->get('translator')->trans('pdf-genesis.menu.'.$child->getName());
            $child->setLabel($label);
        }

        return $menu;
    }

}