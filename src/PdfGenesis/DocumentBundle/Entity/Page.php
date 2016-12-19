<?php

namespace PdfGenesis\DocumentBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Page
 *
 * @ORM\Table(name="page")
 * @ORM\Entity(repositoryClass="PdfGenesis\DocumentBundle\Repository\PageRepository")
 */
class Page
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="paginationOrder", type="integer")
     */
    private $paginationOrder;


    /**
     * @var Document
     *
     * @ORM\ManyToOne(targetEntity="PdfGenesis\DocumentBundle\Entity\Document", inversedBy="pages")
     */
    protected $document;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PdfGenesis\ElementBundle\Entity\Element", mappedBy="page" )
     */
    protected $elements;

    /**
     * @var boolean
     *
     * @ORM\Column(name="activate", type="boolean")
     */
    protected $activate;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string")
     */
    protected $title;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set paginationOrder
     *
     * @param integer $paginationOrder
     *
     * @return Page
     */
    public function setPaginationOrder($paginationOrder)
    {
        $this->paginationOrder = $paginationOrder;

        return $this;
    }

    /**
     * Get paginationOrder
     *
     * @return int
     */
    public function getPaginationOrder()
    {
        return $this->paginationOrder;
    }




    /**
     * Set document
     *
     * @param \PdfGenesis\DocumentBundle\Entity\Document $document
     *
     * @return Page
     */
    public function setDocument(\PdfGenesis\DocumentBundle\Entity\Document $document = null)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return \PdfGenesis\DocumentBundle\Entity\Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Add element
     *
     * @param \PdfGenesis\ElementBundle\Entity\Element $element
     *
     * @return Page
     */
    public function addElement(\PdfGenesis\ElementBundle\Entity\Element $element)
    {
        $this->elements[] = $element;

        return $this;
    }

    /**
     * Remove element
     *
     * @param \PdfGenesis\ElementBundle\Entity\Element $element
     */
    public function removeElement(\PdfGenesis\ElementBundle\Entity\Element $element)
    {
        $this->elements->removeElement($element);
    }

    /**
     * Get elements
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getElements()
    {
        return $this->elements;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->title = DocumentInterface::DEFAULT_TITLE;
        $this->activate = false;
        $this->elements = new \Doctrine\Common\Collections\ArrayCollection();
    }


    /**
     * Set activate
     *
     * @param boolean $activate
     *
     * @return Page
     */
    public function setActivate($activate)
    {
        $this->activate = $activate;

        return $this;
    }

    /**
     * Get activate
     *
     * @return boolean
     */
    public function getActivate()
    {
        return $this->activate;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
