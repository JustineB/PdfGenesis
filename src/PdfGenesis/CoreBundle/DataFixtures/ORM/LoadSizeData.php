<?php


namespace PdfGenesis\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PdfGenesis\ElementBundle\Entity\Size;


class LoadSizeData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $size = new Size();
        $size->setHeight(200);
        $size->setWidth(200);

        $manager->persist($size);
        $manager->flush();
    }
}