<?php

namespace PdfGenesis\ElementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use PdfGenesis\DocumentBundle\Entity\Page;

/**
 * Element
 *
 * @ORM\Table(name="element")
 * @ORM\Entity(repositoryClass="PdfGenesis\ElementBundle\Repository\ElementRepository")
 */
class Element
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var Page
     *
     * @ORM\ManyToOne(targetEntity="PdfGenesis\DocumentBundle\Entity\Page", inversedBy="elements")
     */
    protected $page;

    /**
     * @var File
     *
     * @ORM\ManyToOne(targetEntity="PdfGenesis\ElementBundle\Entity\File", inversedBy="elements" , cascade={"persist"})
     */
    protected $file;

    /**
     * @var Position
     *
     * @ORM\OneToOne(targetEntity="PdfGenesis\ElementBundle\Entity\Position", cascade={"persist"})
     * @ORM\JoinColumn(name="position_id", referencedColumnName="id")
     */
    protected $position;

    /**
     * @var Size
     *
     * @ORM\OneToOne(targetEntity="PdfGenesis\ElementBundle\Entity\Size", cascade={"persist"})
     * @ORM\JoinColumn(name="size_id", referencedColumnName="id")
     */
    protected $size;


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
     * Set name
     *
     * @param string $name
     *
     * @return Element
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * Set page
     *
     * @param \PdfGenesis\DocumentBundle\Entity\Page $page
     *
     * @return Element
     */
    public function setPage(\PdfGenesis\DocumentBundle\Entity\Page $page = null)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * Get page
     *
     * @return \PdfGenesis\DocumentBundle\Entity\Page
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Set file
     *
     * @param \PdfGenesis\ElementBundle\Entity\File $file
     *
     * @return Element
     */
    public function setFile(\PdfGenesis\ElementBundle\Entity\File $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return \PdfGenesis\ElementBundle\Entity\File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set position
     *
     * @param \PdfGenesis\ElementBundle\Entity\Position $position
     *
     * @return Element
     */
    public function setPosition(\PdfGenesis\ElementBundle\Entity\Position $position = null)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return \PdfGenesis\ElementBundle\Entity\Position
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set size
     *
     * @param \PdfGenesis\ElementBundle\Entity\Size $size
     *
     * @return Element
     */
    public function setSize(\PdfGenesis\ElementBundle\Entity\Size $size = null)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return \PdfGenesis\ElementBundle\Entity\Size
     */
    public function getSize()
    {
        return $this->size;
    }
}
