<?php

namespace Meetupos\Application\CommandHandler;

use Meetupos\Domain\Model\Event\Event;
use Meetupos\Domain\Model\Event\EventRepositoryInterface;
use Meetupos\Domain\Model\User\UserAlreadyExistsException;
use Meetupos\Domain\Model\User\UserFactory;
use Meetupos\Domain\Model\User\UserRepository;
use SimpleBus\Message\Handler\MessageHandler;
use SimpleBus\Message\Message;

class CreateEventHandler implements MessageHandler
{
    /** @var  EventFactory */
    protected $eventFactory;

    /** @var  EventRepository */
    protected $eventRepository;

    function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param Message $message
     * @return void
     */
    // TODO pass CreateEvent (command) instead of Message (interface)??
    public function handle(Message $message)
    {
        $event = Event::withTitleAndDescription(
            $this->eventRepository->nextIdentity(),
            $message->title(),
            $message->description()
        );
        $this->eventRepository->add($event);
    }
}
