<?php

namespace Meetupos\Infrastructure\Persistence\InMemory\Account;


use Meetupos\Domain\Model\Account\Account;
use Meetupos\Domain\Model\Account\AccountRepository;

class InMemoryAccountRepository implements AccountRepository, \ArrayAccess
{
    private $data = [];

    public function findByCredentials($credentials)
    {
        foreach ($this->data as $account) {
            if ($account->credentials()->equals($credentials)) {
                return Account::fromCredentials($credentials);
            }
        }

        return null;
    }

    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
