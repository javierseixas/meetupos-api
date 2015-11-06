<?php

namespace Meetupos\Domain\Model\Account;


interface AccountRepository
{
    public function findByCredentials($credentials);
}
