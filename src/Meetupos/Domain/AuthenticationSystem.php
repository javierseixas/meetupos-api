<?php

namespace Meetupos\Domain;

use Meetupos\Domain\Model\Account\Account;
use Meetupos\Domain\Model\Account\AccountRepository;
use Meetupos\Domain\Model\Account\Credentials;

class AuthenticationSystem
{
    private $accounts;

    /**
     * AuthenticationSystem constructor.
     * @param AccountRepository $accountRepository
     */
    public function __construct(AccountRepository $accountRepository)
    {
        $this->accounts = $accountRepository;
    }

    public function authenticates(Credentials $credentials)
    {
        $account = $this->accounts->findByCredentials($credentials);

        return ($account instanceof Account);
    }
}
