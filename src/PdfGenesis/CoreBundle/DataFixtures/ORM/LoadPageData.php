<?php


namespace PdfGenesis\CoreBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use PdfGenesis\DocumentBundle\Entity\Document;
use PdfGenesis\DocumentBundle\Entity\Page;


class LoadPageData implements FixtureInterface
{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param \Doctrine\Common\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        //todo
        $document = new Document();
        $document->setTitle('Default Title');

        $manager->persist($document);
        $manager->flush();


        $page = new Page();
        $page->setPaginationOrder(1);
        $page->setDocument($document);

        $manager->persist($page);
        $manager->flush();
    }
}