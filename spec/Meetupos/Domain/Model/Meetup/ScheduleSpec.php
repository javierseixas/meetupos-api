<?php

namespace spec\Meetupos\Domain\Model\Meetup;

use Meetupos\Domain\Model\Meetup\Meetup;
use Meetupos\Domain\Model\Meetup\MeetupRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ScheduleSpec extends ObjectBehavior
{
    public function let(MeetupRepositoryInterface $repository)
    {
        $this->beConstructedWith($repository);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Meetupos\Domain\Model\Meetup\Schedule');
    }

    public function it_should_return_the_number_of_coming_meetups(MeetupRepositoryInterface $repository)
    {
        $repository->numberOfComingEvents(new \DateTime())->willReturn(2);
        $this->numberOfComingMeetups()->shouldReturn(2);
    }

    public function it_should_return_all_the_meetups_added_in_the_schedule(MeetupRepositoryInterface $repository)
    {
        $meetups = [
            Meetup::withTitleAndDescription("title1", "desc1"),
            Meetup::withTitleAndDescription("title2", "desc2")
        ];
        $repository->all()->willReturn($meetups);
        $this->allMeetups()->shouldReturn($meetups);
    }
}
