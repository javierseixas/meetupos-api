<?php

namespace Meetupos\features\bootstrap;

use Behat\Behat\Context\Context;
use Meetupos\Domain\AuthenticationSystem;
use Meetupos\Domain\Model\Account\Account;
use Meetupos\Domain\Model\Account\Credentials;
use Meetupos\Infrastructure\Persistence\InMemory\Account\InMemoryAccountRepository;
use PHPUnit_Framework_Assert;

class BddContext implements Context
{
    private $accounts;
    private $credentials;

    /**
     * @Given /^an account with username as "([^"]*)" and password "([^"]*)"$/
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
}