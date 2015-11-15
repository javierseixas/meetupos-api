<?php

namespace Meetupos\Domain\Model\Meetup;


interface MeetupRepositoryInterface
{
    public function numberOfComingEvents(\Datetime $date);

    public function add(Meetup $meetup);

    public function all();
}
