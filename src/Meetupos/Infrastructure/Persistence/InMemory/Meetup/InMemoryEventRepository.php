<?php

namespace Meetupos\Infrastructure\Persistence\InMemory\Meetup;

use Meetupos\Domain\Model\Event\Event;
use Meetupos\Domain\Model\Event\EventRepositoryInterface;
use Meetupos\Infrastructure\Persistence\InMemory\InMemoryRepository;

class InMemoryEventRepository extends InMemoryRepository implements \Meetupos\Domain\Model\Event\EventRepositoryInterface
{
    public function numberOfComingEvents(\Datetime $date)
    {
        return count($this->data);
    }

    public function add(Event $meetup)
    {
        $this->data[$meetup->id()] = $meetup;

        return $this;
    }

    public function all()
    {
        return $this->data;
    }
}
