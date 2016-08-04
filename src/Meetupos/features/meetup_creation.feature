# TODO @reset-schema should be inside the ApiContext
@bdd @reset-schema @domain
Feature: Events creation
    As a admin
    I want to create events
    In order to allow people to visualize them in the site

    Background: Event system is based in a Schedule
        Given a Schedule

    @api
    Scenario: I create an event successfully
        Given There are no events in the schedule
         When I create an event titled "Feminismo" and described "This is my description"
         Then a new event titled "Feminismo" should be in the schedule

    Scenario: I get an error if I try to create an event with empty title or description
        Given There are no events in the schedule
         When I create an event with no info
         Then no new event should be in the schedule