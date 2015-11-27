<?php

namespace Meetupos\ApiBundle\Controller;

use Meetupos\Application\Command\CreateEvent;
use Meetupos\Application\CommandHandler\CreateEventHandler;
use Meetupos\Domain\Model\Event\EventRepositoryInterface;
use Symfony\Component\HttpFoundation\Response;

class EventController
{
    private $eventRepository;

    /**
     * EventController constructor.
     */
    public function __construct(EventRepositoryInterface $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function postEvent()
    {
        $commandBus = new CreateEventHandler($this->eventRepository);

        $commandBus->handle(new CreateEvent("Feminismo", "description"));

        return new Response('{ "message": "cool!" }', Response::HTTP_CREATED);
    }
}
