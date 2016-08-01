<?php

namespace Meetupos\features\bootstrap;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;
use Doctrine\ORM\Mapping\ClassMetadata;
use Meetupos\Domain\Model\Event\Event;
use Meetupos\Domain\Model\Event\Schedule;
use Meetupos\Infrastructure\Persistence\Doctrine\ORM\Model\Event\DoctrineEventRepository;
use PHPUnit_Framework_Assert;

class ApiContext extends \Knp\FriendlyContexts\Context\ApiContext implements Context, SnippetAcceptingContext
{
    const HTTP_STATUS_NO_CONTENT = 204;
    const HTTP_STATUS_OK = 200;
    const HTTP_STATUS_CREATED = 201;

    /** @var  \Meetupos\Domain\Model\Event\Schedule */
    private $schedule;

    /** @var  \Meetupos\Domain\Model\Event\Event */
    private $event;


    /**
     * @Given There are no events in the schedule
     */
    public function thereAreNoEventsInTheSchedule()
    {
        // TODO Check database
        $tableNode = new TableNode([]);
        $this->get('friendly.entity_context')->thereIsLikeFollowing(0, "Event", $tableNode);
    }

    /**
     * @When I create an event titled :title and described :description
     */
    public function iCreateAnEventTitledAndDescribedWith($title, $description)
    {
        $this->iPrepareRequest("POST", "/events");
        $this->iSpecifiedTheBody(sprintf('{"title":"%s","description":"%s"}', $title, $description));
        $this->iSendTheRequest();

        $this->assertHttpResponseStatus(self::HTTP_STATUS_CREATED);
    }

    /**
     * @Then a new event titled :title should be in the schedule
     */
    public function aNewEventTitledShouldBeInTheSchedule($title)
    {
        $tableNode = new TableNode([
            0 => ["title"],
            1 => [$title]
        ]);
        $this->get('friendly.entity_context')->existLikeFollowing(1, "Event", $tableNode);
    }

    /**
     * @Given /^There is an event titled "([^"]*)" in the schedule$/
     */
    public function thereIsAnEventTitledInTheSchedule($title)
    {
        $eventDoctrineClassMetadata = new ClassMetadata(Event::class);
        $this->schedule = new Schedule(new DoctrineEventRepository($this->getEntityManager(), $eventDoctrineClassMetadata));
        $this->event = Event::withTitleAndDescription($title, "Some desc");
        $this->schedule->addEvent($this->event);
    }

    /**
     * @When /^I delete the event$/
     */
    public function iDeleteTheEvent()
    {
        $this->iPrepareRequest("DELETE", sprintf("/events/%s", $this->event->id()));
        $this->iSendTheRequest();

        $this->assertHttpResponseStatus(self::HTTP_STATUS_NO_CONTENT);
    }

    /**
     * @Then /^That event should be removed from the schedule$/
     */
    public function thatEventShouldBeRemovedFromTheSchedule()
    {
        $this->getEntityManager()->clear(Event::class);
        $removedEvent = $this->schedule->find($this->event);
        PHPUnit_Framework_Assert::assertNull($removedEvent);
    }

    private function assertHttpResponseStatus($expected)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $expected,
            $this->getResponse()->getStatusCode(),
            sprintf("Wrong HTTP Status: %d expected. Got %d", $expected, $this->getResponse()->getStatusCode())
        );
    }
}
