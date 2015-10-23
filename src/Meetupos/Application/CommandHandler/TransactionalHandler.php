<?php

namespace Meetupos\Application\CommandHandler;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Connection;
use SimpleBus\Message\Bus\Middleware\MessageBusMiddleware;
use SimpleBus\Message\Message;

class TransactionalHandler implements MessageBusMiddleware
{
    /** @var  Connection */
    private $connection;

    function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * The provided $next callable should be called whenever the next middleware should start handling the message.
     * Its only argument should be a Message object (usually the same as the originally provided message).
     *
     * @param Message $message
     * @param callable $next
     * @return void
     */
    public function handle(Message $message, callable $next)
    {
        $this->connection->beginTransaction();
        try {
            $next($message);
            $this->connection->commit();
        } catch (\Exception $e) {
            $this->connection->rollback();
            throw $e;
        }
    }
}