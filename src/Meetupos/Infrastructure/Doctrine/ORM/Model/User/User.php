<?php

namespace Meetupos\Infrastructure\Doctrine\ORM\Model\User;

use Meetupos\Domain\Model\User\User as BaseUser;
use Meetupos\Domain\Model\User\UserId;

class User extends BaseUser
{
    /**
     * Surrogate Id
     * @var string
     */
    protected $surrogateUserId;

    /**
     * @param UserId $userId
     * @param string $email
     * @param string $password
     */
    public function __construct(
        UserId $userId,
        $firstname,
        $lastname,
        $email,
        $password
    ) {
        \Meetupos\Domain\Model\User\parent::__construct($userId, $firstname, $lastname, $email, $password);
        $this->surrogateUserId = $userId->id();
    }

    /**
     * @return UserId
     */
    public function id()
    {
        return new UserId($this->surrogateUserId);
    }
}
