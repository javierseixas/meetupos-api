<?php

namespace Meetupos\Domain\Model\User;


use Meetupos\Domain\Model\User\UserId;

class User
{
    protected $userId;

    protected $firstname;

    protected $lastname;

    protected $email;

    protected $password;

    function __construct(
        UserId $userId,
        $firstname,
        $lastname,
        $email,
        $password
    ) {
        $this->userId = $userId;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->email = $email;
        $this->password = $password;
    }

    public function id()
    {
        return $this->userId;
    }

    public function getFirstname()
    {
        return $this->firstname;
    }

    public function lastname(){
        return $this->lastname;
    }

    public function email()
    {
        return $this->email;
    }

    public function password()
    {
        return $this->password;
    }
}