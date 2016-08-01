<?php

namespace Meetupos\ApiBundle\Controller;

use JMS\Serializer\SerializerInterface;
use Meetupos\Application\Command\CreateEvent;
use Meetupos\Application\Command\DeleteEvent;
use Meetupos\Application\CommandHandler\CreateEventHandler;
use Meetupos\Application\CommandHandler\DeleteEventHandler;
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
     * TODO Controllers should not know about repositories
     */
    public function __construct(EventRepositoryInterface $eventRepository, SerializerInterface $serializer)
    {
        $this->eventRepository = $eventRepository;
        $this->serializer = $serializer;
    }

    public function deleteEvent($id)
    {
        $commandBus = new DeleteEventHandler($this->eventRepository);

        $commandBus->handle(new DeleteEvent($id));

        return new Response("", Response::HTTP_NO_CONTENT);
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

        //TODO Should it be a service?
        $commandBus = new CreateEventHandler($this->eventRepository);

        $commandBus->handle($createEventCommand);

        return new Response(
            $this->serializer->serialize(
                Event::withTitleAndDescription($createEventCommand->title(), $createEventCommand->description()),
                'json'),
            Response::HTTP_CREATED);
    }
}
