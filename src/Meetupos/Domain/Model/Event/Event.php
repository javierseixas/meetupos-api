<?php

namespace Meetupos\Domain\Model\Event;

use Rhumsaa\Uuid\Uuid;

class Event
{
    protected $id;
    protected $title;
    protected $description;

    /** @var \Datetime */
    protected $date;

    /**
     * Event constructor.
     * @param $eventId
     * @param $title
     * @param $description
     * @param $date
     */
    protected function __construct($eventId, $title, $description, $date)
    {
        $this->id = $eventId;
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
    }

    public static function withTitleAndDescription($title, $description)
    {
        if (empty($title) || empty($description)) {
            throw new IncompleteEventException("Event requires to have a title and a description to be created");
        }

        return self::withTitleDescriptionAndDate($title, $description, new \DateTime());
    }

    public static function withTitleDescriptionAndDate($title, $description, \DateTime $date)
    {
        if (empty($title) || empty($description || is_null($date))) {
            throw new IncompleteEventException("Event requires to have a title, a description and a date to be created");
        }

        return new self(Uuid::uuid4()->toString(), $title, $description, $date);
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

    /**
     * @return \DateTime
     */
    public function date()
    {
        return $this->date;
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

    /**
     * @param \DateTime $date
     * @return $this
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }



}
