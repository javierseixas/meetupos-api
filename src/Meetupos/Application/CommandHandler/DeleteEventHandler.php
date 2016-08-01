<?php

namespace Meetupos\Application\CommandHandler;

use Meetupos\Domain\Model\Event\EventRepositoryInterface;
use SimpleBus\Message\Handler\MessageHandler;
use SimpleBus\Message\Message;

class DeleteEventHandler implements MessageHandler
{
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
    public function handle(Message $message)
    {
        //TODO I don't know if calling two times to the repository is ok, considering that it can be done by just one call
        $event = $this->eventRepository->with($message->id());
        $this->eventRepository->delete($event);
    }
}
