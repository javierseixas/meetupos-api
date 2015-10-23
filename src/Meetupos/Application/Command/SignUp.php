<?php

namespace Meetupos\Application\Command;

use SimpleBus\Message\Message;

class SignUp implements Message
{
    /** @var  string */
    private $firstname;

    /** @var  string */
    private $lastname;

    /** @var  string */
    private $email;

    /** @var  string */
    private $password;

    function __construct(
        $name,
        $lastname,
        $email,
        $password
    ) {
        $this->firstname = $name;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function firstname()
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function lastname()
    {
        return $this->lastname;
    }

    /**
     * @return string
     */
    public function email()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function password()
    {
        return $this->password;
    }
}
