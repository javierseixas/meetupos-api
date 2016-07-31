<?php

namespace Meetupos\ApiBundle\Controller;

use JMS\Serializer\SerializerInterface;
use Meetupos\Application\Command\CreateEvent;
use Meetupos\Application\CommandHandler\CreateEventHandler;
use Meetupos\Domain\Model\Event\Event;
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

    // TODO Move this to CQRS?
    public function getEvent($id)
    {
        $event = $this->eventRepository->with($id);

        return new Response(
            $this->serializer->serialize(
                $event,
                'json'),
            Response::HTTP_OK);
    }

    public function postEvent(Request $request)
    {
        $requestBody = $request->getContent();

        $createEventCommand = $this->serializer->deserialize(
            $requestBody,
            CreateEvent::class,
            'json'
        );

        $commandBus = new CreateEventHandler($this->eventRepository);

        $commandBus->handle($createEventCommand);

        return new Response(
            $this->serializer->serialize(
                Event::withTitleAndDescription($createEventCommand->title(), $createEventCommand->description()),
                'json'),
            Response::HTTP_CREATED);
    }
}
