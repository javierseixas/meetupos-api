<?php

namespace Meetupos\Infrastructure\Persistence\InMemory\Meetup;

use Meetupos\Domain\Model\Meetup\Meetup;
use Meetupos\Domain\Model\Meetup\MeetupRepositoryInterface;
use Meetupos\Infrastructure\Persistence\InMemory\InMemoryRepository;

class InMemoryMeetupRepository extends InMemoryRepository implements MeetupRepositoryInterface
{
    public function numberOfComingEvents(\Datetime $date)
    {
        return count($this->data);
    }

    public function add(Meetup $meetup)
    {
        $this->data[$meetup->id()] = $meetup;

        return $this;
    }

    public function all()
    {
        return $this->data;
    }
}
