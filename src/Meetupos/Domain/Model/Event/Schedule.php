<?php

namespace Meetupos\Domain\Model\Event;


class Schedule
{
    private $repository;

    public function __construct(EventRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function numberOfComingEvents()
    {
        return $this->repository->numberOfComingEvents(new \DateTime());
    }

    public function addEvent(Event $event)
    {
        $this->repository->add($event);
        return $this;
    }

    public function allEvents()
    {
        return $this->repository->all();
    }

    public function deleteEvent(Event $event)
    {
        return $this->repository->delete($event);
    }

    public function find(Event $event)
    {
        return $this->repository->with($event->id());
    }
}
