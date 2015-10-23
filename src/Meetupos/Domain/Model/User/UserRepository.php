<?php

namespace Meetupos\Domain\Model\User;

use Meetupos\Domain\Model\User\User;
use Meetupos\Domain\Model\User\UserId;

interface UserRepository
{
    public function findById(UserId $userId);

    public function userWithEmail($email);

    public function findAll();

    public function add(User $user);

    public function remove(User $user);

    public function nextIdentity();
}