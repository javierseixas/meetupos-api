<?php

namespace Meetupos\AuthApiBundle\Features\Context;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Doctrine\DBAL\Schema\Table;
use Knp\FriendlyContexts\Context\ApiContext;
use Groupalia\BizApiBundle\Entity\User;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * Defines application features from the specific context.
 */
class FeatureContext extends ApiContext implements Context, SnippetAcceptingContext
{
    /** @var  KernelInterface */
    protected $kernel;

    protected $userToken;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }

    /**
     * @return \Symfony\Component\DependencyInjection\ContainerInterface
     */
    protected function getContainer()
    {
        return $this->getKernel()->getContainer();
    }

    /**
     * @param string $id
     *
     * @return object
     */
    protected function getService($id)
    {
        return $this->getContainer()->get($id);
    }

    /**
     * @Given /^I have an Authorization token for user:$/
     * @Given /^I have an Authorization token for user with email "(.*)?"$/
     */
    public function iHaveAAuthorizationTokenForUser($data)
    {
        $email = ($data instanceof TableNode) ? $data->getRowsHash()['email'] : $data;

        $user = new User();
        $user->setEmail($email);
        $this->userToken = $this->getService('lexik_jwt_authentication.jwt_manager')->create($user);
    }


    /**
     * @When /^I should receive a (?<httpCode>[0-9]+) response containing:?$/
     */
    public function iReceiveAResponseAndContent($httpCode, PyStringNode $body)
    {
        $this->iShouldReceiveResponse($httpCode);

        if ($diff = $this->container->get('behat.rest.differ')->diff($this->response->getBody(true), $body->getRaw())) {
            throw new \LogicException($diff);
        }
    }

    /**
     * @Then /^I should receive a (?<httpCode>[0-9]+) with a token$/
     */
    public function iShouldReceiveResponseWithAToken($httpCode)
    {
        $responseBody = json_decode($this->response->getBody(true), true);

        if (!isset($responseBody['token']) || !is_scalar($responseBody['token'])) {
            throw new \Exception('The response does not contain any token');
        }

        $this->userToken = $responseBody['token'];
        $this->iShouldReceiveResponse($httpCode);
    }

    /**
     * @Given /^I prepare a (?<method>[A-Za-z]+) request on "(?<page>[^"].*)?" with Authorization token$/
     */
    public function iPrepareRequestWithAuthorization($method, $page)
    {
        if (is_null($this->userToken)) {
            throw new \Exception('It has not been defined a token. Please, use "iShouldReceiveResponseWithAToken" method first.');
        }

        $this->iPrepareRequest($method, $page);
        $this->iSpecifiedHeaders($this->buildTableNodeWithAuthorization());
    }

    /**
     * @Given /^I prepare a (?<method>[A-Za-z]+) request on "(?<page>[^"].*)?" authorized as (?<email>[A-Za-z0-9_\.@]+)$/
     */
    public function iPrepareRequestAuthorizedAs($method, $page, $email)
    {
        $this->iHaveAAuthorizationTokenForUser($email);

        $this->iPrepareRequest($method, $page);
        $this->iSpecifiedHeaders($this->buildTableNodeWithAuthorization());
    }

    /**
     * @return TableNode
     */
    private function buildTableNodeWithAuthorization()
    {
        $tableNode = new TableNode([
            10 => [
                'Authorization',
                sprintf("Bearer %s", $this->userToken),
            ]
        ]);
        return $tableNode;
    }

}
