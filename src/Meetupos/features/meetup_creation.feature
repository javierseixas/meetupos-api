@bdd @domain
Feature: Events creation
    As a admin
    I want to create events
    In order to allow people to visualize them in the site

    @api
    Scenario: I create an event successfully
        Given There are no events in the schedule
         When I create an event titled "Feminismo" and described with "This is my description"
         Then a new event titled "Feminismo" should be in the schedule

