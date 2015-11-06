<?php

namespace spec\Meetupos\Domain;

use Meetupos\Domain\Model\Account\Account;
use Meetupos\Domain\Model\Account\Credentials;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Meetupos\Domain\Model\Account\AccountRepository;

class AuthenticationSystemSpec extends ObjectBehavior
{
    public function let(AccountRepository $accountRepository)
    {
        $this->beConstructedWith($accountRepository);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Meetupos\Domain\AuthenticationSystem');
    }

    public function it_should_return_true_when_an_account_with_the_same_credentials_passed_is_found(AccountRepository $accountRepository)
    {
        $credentials = Credentials::from("javi", "pass");
        $account = Account::fromCredentials($credentials);
        $accountRepository->findByCredentials($credentials)->willReturn($account);

        $this->authenticates($credentials)->shouldReturn(true);
    }


}
