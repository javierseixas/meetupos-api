<?php

namespace Meetupos\Domain\Model\Event;

interface EventRepositoryInterface
{
    public function numberOfComingEvents(\Datetime $date);

    public function add(Event $event);

    public function all();

    public function with($id);

    public function delete(Event $event);

    public function comingEvents(\Datetime $offsetDate);
}
