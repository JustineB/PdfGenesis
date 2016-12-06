<?php


namespace PdfGenesis\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PdfGenesis\ElementBundle\Entity\Position;


class LoadPositionData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $position = new Position();
        $position->setLatitude(0);
        $position->setLongitude(0);

        $manager->persist($position);
        $manager->flush();
    }
}