<?php

namespace Meetupos\Infrastructure\Doctrine\ORM\Persistence\User;

use Meetupos\Domain\Model\User\User;
use Meetupos\Domain\Model\User\UserId;
use Meetupos\Domain\Model\User\UserRepository as BaseUserRepository;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository implements BaseUserRepository
{
    public function findById(UserId $userId)
    {
        return $this->find($userId->id());
    }

    public function add(User $user)
    {
        $this->getEntityManager()->persist($user);
    }

    public function remove(User $user)
    {
        $this->getEntityManager()->remove($user);
    }

    public function userWithEmail($email)
    {
        return $this->findOneBy(['email' => $email]);
    }

    public function nextIdentity()
    {
        return new UserId();
    }
}