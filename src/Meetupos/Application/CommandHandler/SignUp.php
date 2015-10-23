<?php

namespace Meetupos\Application\CommandHandler;

use RealFunding\Domain\Model\User\UserAlreadyExistsException;
use RealFunding\Domain\Model\User\UserFactory;
use RealFunding\Domain\Model\User\UserRepository;
use SimpleBus\Message\Handler\MessageHandler;
use SimpleBus\Message\Message;

class SignUp implements MessageHandler
{
    /** @var  UserFactory */
    protected $userFactory;

    /** @var  UserRepository */
    protected $userRepository;

    function __construct(UserFactory $userFactory, UserRepository $userRepository)
    {
        $this->userFactory = $userFactory;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Message $message
     * @return void
     */
    public function handle(Message $message)
    {
        if (null !== $user = $this->userRepository->userWithEmail($message->email())) {
            throw new UserAlreadyExistsException();
        }

        $user = $this->userFactory->create(
            $this->userRepository->nextIdentity(),
            $message->firstname(),
            $message->lastname(),
            $message->email(),
            $message->password()
        );

        $this->userRepository->add($user);
    }
}
