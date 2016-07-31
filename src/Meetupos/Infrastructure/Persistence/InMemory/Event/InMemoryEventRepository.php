<?php

namespace Meetupos\Infrastructure\Persistence\InMemory\Event;

use Meetupos\Domain\Model\Event\Event;
use Meetupos\Domain\Model\Event\EventRepositoryInterface;
use Meetupos\Infrastructure\Persistence\InMemory\InMemoryRepository;

class InMemoryEventRepository extends InMemoryRepository implements EventRepositoryInterface
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

    public function with($id)
    {
        foreach ($this->data as $eventId => $eventInSchedule) {
            if ($eventId === $id) {
                return $eventInSchedule;
            }
        }

        return null;
    }

    public function delete(Event $event)
    {
        foreach ($this->data as $eventId => $eventInSchedule) {
            if ($eventId === $event->id()) {
                unset($this->data[$eventId]);
            }
        }
    }
}
