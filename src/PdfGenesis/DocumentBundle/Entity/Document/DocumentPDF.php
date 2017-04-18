<?php

namespace PdfGenesis\DocumentBundle\Entity\Document;

use Doctrine\ORM\Mapping as ORM;
use PdfGenesis\DocumentBundle\Entity\Document;

/**
 * DocumentPDF
 *
 * @ORM\Table(name="document_document_p_d_f")
 * @ORM\Entity(repositoryClass="PdfGenesis\DocumentBundle\Repository\Document\DocumentPDFRepository")
 */
class DocumentPDF
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
     * @ORM\Column(name="file", type="string", length=255)
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", length=255)
     */
    private $path;

    /**
     * @var Document
     *
     * @ORM\OneToOne(targetEntity="PdfGenesis\DocumentBundle\Entity\Document", cascade={"all"})
     * @ORM\JoinColumn(name="document", referencedColumnName="id")
     */
    protected $document;


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
     * Set file
     *
     * @param string $file
     *
     * @return DocumentPDF
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file
     *
     * @return string
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return DocumentPDF
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param Document $document
     */
    public function setDocument($document)
    {
        $this->document = $document;
    }
}

