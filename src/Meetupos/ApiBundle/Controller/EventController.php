<?php

namespace Meetupos\ApiBundle\Controller;

use JMS\Serializer\SerializerInterface;
use Meetupos\Application\Command\CreateEvent;
use Meetupos\Application\CommandHandler\CreateEventHandler;
use Meetupos\Domain\Model\Event\EventRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EventController
{
    private $eventRepository;
    private $serializer;

    /**
     * EventController constructor.
     * TODO Coupled to the JMS Serializer
     */
    public function __construct(EventRepositoryInterface $eventRepository, SerializerInterface $serializer)
    {
        $this->eventRepository = $eventRepository;
        $this->serializer = $serializer;
    }

    public function postEvent(Request $request)
    {
        $requestBody = $request->getContent();

        $createEventCommand = $this->serializer->deserialize(
            $requestBody,
            "Meetupos\\Application\\Command\\CreateEvent",
            'json'
        );

        $commandBus = new CreateEventHandler($this->eventRepository);

        $commandBus->handle($createEventCommand);

        return new Response('{ "message": "cool!" }', Response::HTTP_CREATED);
    }
}
