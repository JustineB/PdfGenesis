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

}