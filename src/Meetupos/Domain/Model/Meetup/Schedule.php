<?php

namespace Meetupos\Domain\Model\Meetup;


class Schedule
{
    private $repository;

    public function __construct(MeetupRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function numberOfComingMeetups()
    {
        return $this->repository->numberOfComingEvents(new \DateTime());
    }

    public function addMeetup(Meetup $meetup)
    {
        $this->repository->add($meetup);
        return $this;
    }

    public function allMeetups()
    {
        return $this->repository->all();
    }
}
