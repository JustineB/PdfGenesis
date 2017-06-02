<?php

namespace PdfGenesis\DocumentBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PdfGenesis\DocumentBundle\Entity\Document\DocumentImage;
use PdfGenesis\DocumentBundle\Entity\Document\DocumentPDF;

/**
 * Document
 *
 * @ORM\Table(name="document")
 * @ORM\Entity(repositoryClass="PdfGenesis\DocumentBundle\Repository\DocumentRepository")
 */



class Document
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt;


    /**
     * @var Library
     *
     * @ORM\ManyToOne(targetEntity="PdfGenesis\DocumentBundle\Entity\Library", inversedBy="documents", cascade={"persist"})
     */
    protected $library;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PdfGenesis\DocumentBundle\Entity\Page", mappedBy="document" , cascade={"all"})
     */
    protected $pages;

    /**
     * @var DocumentImage
     *
     * @ORM\OneToOne(targetEntity="PdfGenesis\DocumentBundle\Entity\Document\DocumentImage", cascade={"all"})
     * @ORM\JoinColumn(name="image", referencedColumnName="id")
     */
    protected $documentImg;

    /**
     * @var DocumentPDF
     *
     * @ORM\OneToOne(targetEntity="PdfGenesis\DocumentBundle\Entity\Document\DocumentPDF", cascade={"all"})
     * @ORM\JoinColumn(name="pdf", referencedColumnName="id")
     */
    protected $documentPdf;

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
     * Set title
     *
     * @param string $title
     *
     * @return Document
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

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Document
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Document
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Document
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }



    /**
     * Set library
     *
     * @param \PdfGenesis\DocumentBundle\Entity\Library $library
     *
     * @return Document
     */
    public function setLibrary(\PdfGenesis\DocumentBundle\Entity\Library $library = null)
    {
        $this->library = $library;

        return $this;
    }

    /**
     * Get library
     *
     * @return \PdfGenesis\DocumentBundle\Entity\Library
     */
    public function getLibrary()
    {
        return $this->library;
    }

    /**
     * Add page
     *
     * @param \PdfGenesis\DocumentBundle\Entity\Page $page
     *
     * @return Document
     */
    public function addPage(\PdfGenesis\DocumentBundle\Entity\Page $page)
    {
        $this->pages[] = $page;

        return $this;
    }

    /**
     * Remove page
     *
     * @param \PdfGenesis\DocumentBundle\Entity\Page $page
     */
    public function removePage(\PdfGenesis\DocumentBundle\Entity\Page $page)
    {
        $this->pages->removeElement($page);
    }

    /**
     * Get pages
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPages()
    {
        return $this->pages;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->pages = new \Doctrine\Common\Collections\ArrayCollection();
        $this->createdAt = new \DateTime('now');
    }

    /**
     * @return mixed
     */
    public function getDocumentPdf()
    {
        return $this->documentPdf;
    }

    /**
     * @param DocumentPDF $documentPdf
     */
    public function setDocumentPdf(DocumentPDF $documentPdf = null)
    {
        $this->documentPdf = $documentPdf;
    }

    /**
     * @return mixed
     */
    public function getDocumentImg()
    {
        return $this->documentImg;
    }

    /**
     * @param DocumentImage $documentImg
     */
    public function setDocumentImg(DocumentImage $documentImg = null)
    {
        $this->documentImg = $documentImg;
    }

}
