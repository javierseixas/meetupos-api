<?php

namespace Meetupos\features\bootstrap;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Meetupos\Domain\AuthenticationSystem;
use Meetupos\Domain\Model\Account\Account;
use Meetupos\Domain\Model\Account\Credentials;
use Meetupos\Domain\Model\Event\Schedule;
use Meetupos\Domain\Model\Event\Event;
use Meetupos\Infrastructure\Persistence\InMemory\Account\InMemoryAccountRepository;
use Meetupos\Infrastructure\Persistence\InMemory\Event\InMemoryEventRepository;
use PHPUnit_Framework_Assert;
use PHPUnit_Framework_Constraint_ArraySubset;

// TODO The initialization of the schedule object is common for all the Given step. It should be extracted
class BddContext implements Context, SnippetAcceptingContext
{
    protected $outcome;
    private $accounts;
    private $credentials;

    /** @var  \Meetupos\Domain\Model\Event\Schedule */
    private $schedule;

    /** @var  \Meetupos\Domain\Model\Event\Event */
    private $event;

    /**
     * @Given /^an account with username as "([^"]*)" and password "([^"]*)"$/
     * @Given /^a user with username "([^"]*)" and password "([^"]*)" signed up$/
     * @Given /^I signed up with username "([^"]*)" and password "([^"]*)"$/
     */
    public function anAccountWithUsernameAsAndPassword($username, $password)
    {
        $credentials = Credentials::from($username, $password);
        $this->accounts = new InMemoryAccountRepository();
        $this->accounts[] = Account::fromCredentials($credentials);
    }

    /**
     * @When /^I give my credentials as username "([^"]*)" and password "([^"]*)" to the system$/
     */
    public function iGiveMyCredentialsAsUsernameAndPasswordToTheSystem($username, $password)
    {
        $this->credentials = Credentials::from($username, $password);
    }

    /**
     * @Then /^I am authenticated by the system$/
     */
    public function iAmAuthenticatedByTheSystem()
    {
        $system = new AuthenticationSystem($this->accounts);
        PHPUnit_Framework_Assert::assertTrue($system->authenticates($this->credentials));
    }

    /**
     * @Then /^I am refused by the system$/
     */
    public function iAmRefusedByTheSystem()
    {
        $system = new AuthenticationSystem($this->accounts);
        PHPUnit_Framework_Assert::assertFalse($system->authenticates($this->credentials));
    }

    /**
     * @When There are no events in the schedule
     */
    public function thereAreNoEventsInTheSchedule()
    {
        $this->schedule = new Schedule(new InMemoryEventRepository());
        PHPUnit_Framework_Assert::assertEquals($this->schedule->numberOfComingEvents(), 0);
    }

    /**
     * @When I create an event titled :title and described :description
     */
    public function iCreateAnEventTitledAndDescribed($title, $description)
    {
        $event = Event::withTitleAndDescription($title, $description);
        $this->schedule->addEvent($event);
    }

    /**
     * @Then a new event titled :title should be in the schedule
     */
    public function aNewEventTitledShouldBeInTheSchedule($title)
    {
        PHPUnit_Framework_Assert::assertEquals($this->schedule->numberOfComingEvents(), 1);
        $events = $this->schedule->allEvents();
        /** @var \Meetupos\Domain\Model\Event\Event $event */
        $event = array_shift($events);
        PHPUnit_Framework_Assert::assertEquals($event->title(), $title);
    }

    /**
     * @When I create an event with no info
     */
    public function iCreateAnEventWithNoInfo()
    {
        try {
            $this->iCreateAnEventTitledAndDescribed("", "");
        }
        catch(\Exception $ex) {
            $this->outcome = $ex;
        }
    }

    /**
     * @Then no new event should be in the schedule
     */
    public function noNewEventShouldBeInTheSchedule()
    {
        PHPUnit_Framework_Assert::assertEquals($this->schedule->numberOfComingEvents(), 0);
    }

    /**
     * @Given /^There is an event titled "([^"]*)" in the schedule$/
     */
    public function thereIsAnEventTitledInTheSchedule($title)
    {
        $this->schedule = new Schedule(new InMemoryEventRepository());
        $this->event = Event::withTitleAndDescription($title, "Some desc");
        $this->schedule->addEvent($this->event);
    }

    /**
     * @When /^I delete the event$/
     */
    public function iDeleteTheEvent()
    {
        $this->schedule->deleteEvent($this->event);
    }

    /**
     * @Then /^That event should be removed from the schedule$/
     */
    public function thatEventShouldBeRemovedFromTheSchedule()
    {
        PHPUnit_Framework_Assert::assertNull($this->schedule->find($this->event));
    }

    /**
     * @Given /^There are a couple of events in the schedule$/
     */
    public function thereAreACoupleOfEventsInTheSchedule()
    {
        $this->schedule = new Schedule(new InMemoryEventRepository());

        $firstEvent = Event::withTitleAndDescription("Catan", "Best boardgame");
        $secondEvent = Event::withTitleAndDescription("Cuatrola", "Quite good card game");

        $this->schedule
            ->addEvent($firstEvent)
            ->addEvent($secondEvent);
    }

    /**
     * @When /^I access the list$/
     * TODO I don't see the point to this step in a Domain Context
     */
    public function iAccessTheList()
    {
        $this->schedule->comingEvents();
    }

    /**
     * @Then /^I see these events listed$/
     * @Then /^I see only the coming events listed$/
     */
    public function iSeeTheseEventsListed()
    {
        $expectedEvents = ["Catan", "Cuatrola"];

        $this->assertThatComingEventsMatchExpected($expectedEvents);
    }

    /**
     * @Given /^There is a past event in the schedule$/
     */
    public function thereIsAPastEventInTheSchedule()
    {
        // TODO The schedule is set before, but in another step. It should be created outside of an step, like in a background
        $pastEvent = Event::withTitleDescriptionAndDate("Risk", "Depends to much on luck", new \DateTime("1 day ago"));

        $this->schedule->addEvent($pastEvent);
    }

    /**
     * @param $expectedEvents
     */
    private function assertThatComingEventsMatchExpected($expectedEvents)
    {
        $foundElements = [];

        foreach ($this->schedule->comingEvents() as $event) {
            if (in_array($event->title(), $expectedEvents)) {
                $foundElements[] = $event->title();
            }
        }

        PHPUnit_Framework_Assert::assertCount(count($expectedEvents), $foundElements);
        $matchExpectedEvents = new PHPUnit_Framework_Constraint_ArraySubset($expectedEvents);
        PHPUnit_Framework_Assert::assertThat($foundElements, $matchExpectedEvents);
    }

    /**
     * @Given /^a Schedule$/
     */
    public function aSchedule()
    {
        throw new PendingException();
    }
}
