<?php

namespace Meetupos\Infrastructure\Persistence\InMemory\Account;

use Meetupos\Domain\Model\Account\Account;
use Meetupos\Domain\Model\Account\AccountRepository;
use Meetupos\Infrastructure\Persistence\InMemory\InMemoryRepository;

class InMemoryAccountRepository extends InMemoryRepository implements AccountRepository, \ArrayAccess
{

    public function findByCredentials($credentials)
    {
        foreach ($this->data as $account) {
            if ($account->credentials()->equals($credentials)) {
                return Account::fromCredentials($credentials);
            }
        }

        return null;
    }
}
