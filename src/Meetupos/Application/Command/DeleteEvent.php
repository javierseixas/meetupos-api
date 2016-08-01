<?php

namespace Meetupos\Application\Command;

use SimpleBus\Message\Message;

class DeleteEvent implements Message
{
    /** @var  string */
    private $id;


    function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
}
