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

    public function delete(Event $event)
    {
        $this->getEntityManager()->remove($event);
        $this->getEntityManager()->flush($event);
    }

    public function comingEvents(\Datetime $offsetDate)
    {
        $em = $this->getEntityManager();
        $qb = $em->createQueryBuilder();

        $q  = $qb->select('e')
            // TODO Provar los dos models de Event
            ->from('Meetupos\Infrastructure\Persistence\Doctrine\ORM\Model\Event\DoctrineEvent', 'e')
            ->where(
                $qb->expr()->gt('e.date', ':from')
            )
            ->setParameter("from", new \DateTime('now'))
            ->orderBy('e.date', 'ASC')
            ->getQuery();

        return $q->getResult();
    }
}
