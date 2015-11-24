<?php

namespace Meetupos\Domain\Model\Event;


class IncompleteEventException extends \Exception
{
    /**
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
