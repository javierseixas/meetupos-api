# TODO @reset-schema should be inside the ApiContext
@bdd @reset-schema @domain
Feature: Events deletion
    As a admin
    I want to delete events
    In order to remove events that are not going to happen

    Background: Event system is based in a Schedule
        Given a Schedule

    @api
    Scenario: I delete an event successfully
        Given There is an event titled "Heteropatriarcado" in the schedule
         When I delete the event
         Then That event should be removed from the schedule