<?php

namespace PdfGenesis\DocumentBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use PdfGenesis\CoreBundle\Entity\User;

/**
 * Library
 *
 * @ORM\Table(name="library")
 * @ORM\Entity(repositoryClass="PdfGenesis\DocumentBundle\Repository\LibraryRepository")
 */
class Library
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
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;


    /**
     * @var user
     *
     * @ORM\OneToOne(targetEntity="PdfGenesis\CoreBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="PdfGenesis\DocumentBundle\Entity\Document", mappedBy="library")
     */
    protected $documents;

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
     * @return Library
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
     * Set user
     *
     * @param \PdfGenesis\CoreBundle\Entity\User $user
     *
     * @return Library
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \PdfGenesis\CoreBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }


    /**
     * Add document
     *
     * @param \PdfGenesis\DocumentBundle\Entity\Document $document
     *
     * @return Library
     */
    public function addDocument(\PdfGenesis\DocumentBundle\Entity\Document $document)
    {
        $this->documents[] = $document;

        return $this;
    }

    /**
     * Remove document
     *
     * @param \PdfGenesis\DocumentBundle\Entity\Document $document
     */
    public function removeDocument(\PdfGenesis\DocumentBundle\Entity\Document $document)
    {
        $this->documents->removeElement($document);
    }

    /**
     * Get documents
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDocuments()
    {
        return $this->documents;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->documents = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
