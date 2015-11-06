<?php

namespace Meetupos\Domain\Model\Account;


class Credentials
{
    private $username;
    private $password;

    /**
     * @param $username
     * @param $password
     */
    public function __construct($username, $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public static function from($username, $password)
    {
        return new Credentials($username, $password);
    }

    public function equals(Credentials $credentials)
    {
        return $credentials->username === $this->username && $credentials->password === $this->password;
    }
}
