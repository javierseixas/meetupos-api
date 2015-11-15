<?php

namespace Meetupos\features\bootstrap;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Meetupos\Domain\AuthenticationSystem;
use Meetupos\Domain\Model\Account\Account;
use Meetupos\Domain\Model\Account\Credentials;
use Meetupos\Domain\Model\Meetup\Schedule;
use Meetupos\Domain\Model\Meetup\Meetup;
use Meetupos\Infrastructure\Persistence\InMemory\Account\InMemoryAccountRepository;
use Meetupos\Infrastructure\Persistence\InMemory\Meetup\InMemoryMeetupRepository;
use PHPUnit_Framework_Assert;

class BddContext implements Context, SnippetAcceptingContext
{
    private $accounts;
    private $credentials;

    private $meetups;
    /** @var  Schedule */
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
     * @Given There are no meetups in the schedule
     */
    public function thereAreNoMeetupsInTheSchedule()
    {
        $this->schedule = new Schedule(new InMemoryMeetupRepository());
        PHPUnit_Framework_Assert::assertEquals($this->schedule->numberOfComingMeetups(), 0);
    }

    /**
     * @When I create a meetup titled :title and described with :description
     */
    public function iCreateAMeetupTitledAndDescribedWith($title, $description)
    {
        $meetup = Meetup::withTitleAndDescription($title, $description);
        $this->schedule->addMeetup($meetup);
    }

    /**
     * @Then a new meetup titled :title should be in the schedule
     */
    public function iNewMeetupTitledShouldBeInTheSchedule($title)
    {
        PHPUnit_Framework_Assert::assertEquals($this->schedule->numberOfComingMeetups(), 1);
        $meetups = $this->schedule->allMeetups();
        /** @var Meetup $meetup */
        $meetup = array_shift($meetups);
        PHPUnit_Framework_Assert::assertEquals($meetup->title(), $title);
    }
}
