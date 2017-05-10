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

        $menu->addChild('concept', array('route' => 'homepage'));
        $menu->addChild('design', array('route' => 'design'));

        if($this->container->get('security.authorization_checker')->isGranted('ROLE_USER')){
            $menu->addChild('account', array('route' => 'user_index'))->setLabel('My account');
            $menu->addChild('logout', array('route' => 'logout'))->setLabel('Logout');
        }else{
            $menu->addChild('login-sign-up', array('uri' => '#'));

        }


        foreach ($menu->getChildren() as $child){
            $label = $this->container->get('translator')->trans('pdf-genesis.menu.'.$child->getName());
            $child->setLabel($label);
        }

        return $menu;
    }

}