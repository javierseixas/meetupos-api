<?php

namespace Meetupos\Domain\Model\Meetup;


use Rhumsaa\Uuid\Uuid;

class Meetup
{
    protected $id;
    protected $title;
    protected $description;

    /**
     * Meetup constructor.
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
        return new Meetup($title, $description);
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
