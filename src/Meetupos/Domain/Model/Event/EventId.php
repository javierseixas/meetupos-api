<?php

namespace Meetupos\Domain\Model\Event;

use Rhumsaa\Uuid\Uuid;

class EventId
{
    private $id;

    public function __construct($id = null)
    {
        $this->id = null === $id ? Uuid::uuid4()->toString() : $id;
    }

    /**
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @param EventId $userId
     *
     * @return bool
     */
    public function equals(EventId $userId)
    {
        return $this->id() === $userId->id();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id();
    }
}
