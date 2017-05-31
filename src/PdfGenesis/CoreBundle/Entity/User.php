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
     * @ORM\Column(name="email_available", type="boolean")
     */
    private $emailAvailable;

    /**
     * @var string
     *
     * @ORM\Column(name="email_token", type="string", nullable=true)
     */
    private $emailToken;

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


    /**
     * @var string
     *
     * @ORM\Column(name="facebook_id", type="string", length=255, nullable=true)
     */
    protected $facebook_id;

    /**
     * @var string
     *
     * @ORM\Column(name="facebook_access_token", type="string", length=255, nullable=true)
     */
    protected $facebook_access_token;


    /**
     * @var string
     *
     * @ORM\Column(name="google_id", type="string", length=255, nullable=true)
     */
    protected $google_id;

    /**
     * @var string
     *
     * @ORM\Column(name="google_access_token", type="string", length=255, nullable=true)
     * */
    protected $google_access_token;


    public function __construct()
    {
        parent::__construct();

        $this->createdAt = new \DateTime('now');
        $this->library = new Library();
        $this->emailAvailable = 1;
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

    /**
     * Set emailAvailable
     *
     * @param string $emailAvailable
     *
     * @return User
     */
    public function setEmailAvailable($emailAvailable)
    {
        $this->emailAvailable = $emailAvailable;

        return $this;
    }

    /**
     * Get emailAvailable
     *
     * @return string
     */
    public function getEmailAvailable()
    {
        return $this->emailAvailable;
    }

    /**
     * Set emailToken
     *
     * @param string $emailToken
     *
     * @return User
     */
    public function setEmailToken($emailToken = null)
    {
        $this->emailToken = $emailToken;

        return $this;
    }

    /**
     * Get emailToken
     *
     * @return string
     */
    public function getEmailToken()
    {
        return $this->emailToken;
    }

    /**
     * @return mixed
     */
    public function getFacebookId()
    {
        return $this->facebook_id;
    }

    /**
     * @param mixed $facebook_id
     */
    public function setFacebookId($facebook_id)
    {
        $this->facebook_id = $facebook_id;
    }

    /**
     * @return mixed
     */
    public function getFacebookAccessToken()
    {
        return $this->facebook_access_token;
    }

    /**
     * @param mixed $facebook_access_token
     */
    public function setFacebookAccessToken($facebook_access_token)
    {
        $this->facebook_access_token = $facebook_access_token;
    }

    /**
     * @return mixed
     */
    public function getGoogleAccessToken()
    {
        return $this->google_access_token;
    }

    /**
     * @param mixed $google_access_token
     */
    public function setGoogleAccessToken($google_access_token)
    {
        $this->google_access_token = $google_access_token;
    }

    /**
     * @return mixed
     */
    public function getGoogleId()
    {
        return $this->google_id;
    }

    /**
     * @param mixed $google_id
     */
    public function setGoogleId($google_id)
    {
        $this->google_id = $google_id;
    }
}