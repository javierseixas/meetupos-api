<?php

namespace Meetupos\Domain\Model\Account;


class Account
{
    private $credentials;

    /**
     * @param $username
     */
    public function __construct(Credentials $credentials)
    {
        $this->credentials = $credentials;
    }

    public static function fromCredentials($credentials)
    {
        return new Account($credentials);
    }

    /**
     * @return Credentials
     */
    public function credentials()
    {
        return $this->credentials;
    }


}
