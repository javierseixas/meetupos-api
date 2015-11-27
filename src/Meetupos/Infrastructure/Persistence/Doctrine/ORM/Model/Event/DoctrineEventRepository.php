<?php

namespace Meetupos\Infrastructure\Persistence\Doctrine\ORM\Model\Event;


use Doctrine\ORM\EntityRepository;
use Meetupos\Domain\Model\Event\Event;
use Meetupos\Domain\Model\Event\EventRepositoryInterface;

class DoctrineEventRepository extends EntityRepository implements EventRepositoryInterface
{

    public function numberOfComingEvents(\Datetime $date)
    {
        // TODO: Implement numberOfComingEvents() method.
    }

    public function add(Event $event)
    {
        $this->getEntityManager()->persist($event);
        $this->getEntityManager()->flush();
    }

    public function all()
    {
        // TODO: Implement all() method.
    }

    public function with($id)
    {
        return $this->find($id);
    }
}
