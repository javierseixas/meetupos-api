<?php

namespace Meetupos\Domain\Model\Event;

interface EventRepositoryInterface
{
    public function numberOfComingEvents(\Datetime $date);

    public function add(Event $meetup);

    public function all();
}
