# TODO @reset-schema should be inside the ApiContext
# TODO I'm coupling this features to some infrastructure (Doctrine) by using alice? May I have to put the alice in other place?
@domain @reset-schema @alice(basic_events)
Feature: List coming events
    As a user
    I want to list coming events
    In order to be able to join that event

    Background: Event system is based in a Schedule
        Given a Schedule

    Scenario: I list all coming events when there is only coming events
        Given There are a couple of events in the schedule
         When I access the list
         Then I see these events listed

    @api
    Scenario: I list all coming events, and not past, when there is both
        Given There are a couple of events in the schedule
          And There is a past event in the schedule
         When I access the list
         Then I see only the coming events listed
