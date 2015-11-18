<?php

namespace Meetupos\features\bootstrap;

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\TableNode;

class ApiContext extends \Knp\FriendlyContexts\Context\ApiContext implements Context, SnippetAcceptingContext
{
    /**
     * @Given There are no events in the schedule
     */
    public function thereAreNoEventsInTheSchedule()
    {
        // TODO Check database
        $tableNode = new TableNode([]);
        $this->get('friendly.entity_context')->thereIsLikeFollowing(0, "DoctrineEvent", $tableNode);
    }

    /**
     * @When I create an event titled :title and described with :description
     */
    public function iCreateAnEventTitledAndDescribedWith($title, $description)
    {
        // TODO For me is weird sending a request and ignoring the response. Think if I should check for the status at least
        $this->iPrepareRequest("POST", "/events");
        $this->iSpecifiedTheBody(sprintf('{"title":"%s","description":"%s"}', $title, $description));
        $this->iSendTheRequest();
    }

    /**
     * @Then a new event titled :title should be in the schedule
     */
    public function aNewEventTitledShouldBeInTheSchedule($title)
    {
        $tableNode = new TableNode([
            0 => ["title"],
            1 => [$title]
        ]);
        $this->get('friendly.entity_context')->existLikeFollowing(1, "DoctrineEvent", $tableNode);
    }
}
