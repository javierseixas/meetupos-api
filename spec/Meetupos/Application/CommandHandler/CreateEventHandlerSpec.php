<?php

namespace spec\Meetupos\Application\CommandHandler;

use Meetupos\Application\Command\CreateEvent;
use Meetupos\Domain\Model\Event\Event;
use Meetupos\Domain\Model\Event\EventId;
use Meetupos\Domain\Model\Event\EventRepositoryInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CreateEventHandlerSpec extends ObjectBehavior
{
    public function let(EventRepositoryInterface $eventRepository)
    {
        $this->beConstructedWith($eventRepository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Meetupos\Application\CommandHandler\CreateEventHandler');
    }

     public function it_should_create_a_new_event(CreateEvent $command, EventRepositoryInterface $eventRepository, EventId $eventId)
    {
        $eventTitle = "title";
        $eventDescription = "description";

        $command->title()->willReturn($eventTitle);
        $command->description()->willReturn($eventDescription);

        $event = Event::withTitleAndDescription($eventTitle, $eventDescription);

        $eventRepository->add($event)->shouldBeCalled();

        $this->handle($command);
    }
}
