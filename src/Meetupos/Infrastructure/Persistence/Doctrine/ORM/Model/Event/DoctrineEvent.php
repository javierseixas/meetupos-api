<?php

namespace Meetupos\Infrastructure\Persistence\Doctrine\ORM\Model\Event;

use Meetupos\Domain\Model\Event\Event;

class DoctrineEvent extends Event
{
    // TODO I don't like to create fake construct and creating setters for allowing using FriendlyEntityContext for acceptance test

    /**
     * Event constructor.
     */
    public function __construct()
    {
        parent::__construct("", "");
    }

    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }
}
