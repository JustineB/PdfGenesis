<?php

namespace PdfGenesis\CoreBundle\Event;

use PdfGenesis\CoreBundle\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class UserEvent extends Event
{

    protected $user;


    public function __construct(User $user){
        $this->user = $user;
    }

    public function getData(){
        return $this->user;
    }


}