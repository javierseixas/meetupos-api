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
}
