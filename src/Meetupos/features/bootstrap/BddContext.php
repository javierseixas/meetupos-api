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
use Meetupos\Infrastructure\Persistence\InMemory\Meetup\InMemoryEventRepository;
use PHPUnit_Framework_Assert;

class BddContext implements Context, SnippetAcceptingContext
{
    protected $outcome;
    private $accounts;
    private $credentials;

    /** @var  \Meetupos\Domain\Model\Event\Schedule */
    private $schedule;

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
     * @Given There are no events in the schedule
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
}
