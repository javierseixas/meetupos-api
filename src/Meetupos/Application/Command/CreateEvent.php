<?php

namespace Meetupos\Application\Command;

use SimpleBus\Message\Message;

class CreateEvent implements Message
{
    /** @var  string */
    private $title;

    /** @var  string */
    private $description;

    function __construct(
        $title,
        $description
    ) {
        $this->title = $title;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
}
