<?php

namespace Meetupos\Domain\Model\Event;

use Rhumsaa\Uuid\Uuid;

class Event
{
    protected $id;
    protected $title;
    protected $description;

    /**
     * Event constructor.
     * @param $title
     * @param $description
     */
    public function __construct($title, $description)
    {
        $this->id = Uuid::uuid4()->toString();
        $this->title = $title;
        $this->description = $description;
    }

    public static function withTitleAndDescription($title, $description)
    {
        return new Event($title, $description);
    }

    public function id()
    {
        return $this->id;
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
