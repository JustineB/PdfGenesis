<?php

namespace PdfGenesis\CoreBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use PdfGenesis\DocumentBundle\Entity\Library;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="file_picture", type="string", length=255, nullable=true)
     */
    private $file;

    /**
     * @var string
     *
     * @ORM\Column(name="path_picture", type="string", length=255, nullable=true)
     */
    private $path;


    /**
     * @var Library
     *
     * @ORM\OneToOne(targetEntity="PdfGenesis\DocumentBundle\Entity\Library", cascade={"persist"})
     * @ORM\JoinColumn(name="library_id", referencedColumnName="id")
     */
    private $library;


    public function __construct()
    {
        parent::__construct();

        $this->createdAt = new \DateTime('now');
        $this->library = new Library();
    }

    /**
     * Get CreatedAt
     * @return \DateTime
     */
    public function getCreatedAt(){
        return $this->createdAt;
    }

    /**
     * Get library
     * @return Library
     */
    public function getLibrary(){
        return $this->library;
    }

    /**
     * Set file
     *
     * @param string $file
     *
     * @return User
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get filePicture
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
     * @return User
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
}