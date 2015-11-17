<?php

namespace spec\Meetupos\Domain\Model\Event;

use Meetupos\Domain\Model\Event\Event;
use Meetupos\Domain\Model\Event\EventRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ScheduleSpec extends ObjectBehavior
{
    public function let(EventRepositoryInterface $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Meetupos\Domain\Model\Event\Schedule');
    }

    public function it_should_return_the_number_of_coming_events(EventRepositoryInterface $repository)
    {
        $repository->numberOfComingEvents(new \DateTime())->willReturn(2);
        $this->numberOfComingEvents()->shouldReturn(2);
    }

    public function it_should_return_all_the_events_added_in_the_schedule(EventRepositoryInterface $repository)
    {
        $meetups = [
            Event::withTitleAndDescription("title1", "desc1"),
            Event::withTitleAndDescription("title2", "desc2")
        ];
        $repository->all()->willReturn($meetups);
        $this->allEvents()->shouldReturn($meetups);
    }
}
