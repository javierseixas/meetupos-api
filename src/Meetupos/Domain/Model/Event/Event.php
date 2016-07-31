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
    protected function __construct($eventId, $title, $description)
    {
        $this->id = $eventId;
        $this->title = $title;
        $this->description = $description;
    }

    public static function withTitleAndDescription($title, $description)
    {
        if (empty($title) || empty($description)) {
            throw new IncompleteEventException("Event requires to have a title and a description to be created");
        }

        return new self(Uuid::uuid4()->toString(), $title, $description);
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

    // TODO Removes setters

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

}
