@bdd @domain
Feature: Meetups creation
    As a admin
    I want to create meetups
    In order to allow people to visualize them in the site

    Scenario: I create a meetup successfully
        Given There are no meetups in the schedule
         When I create a meetup titled "Feminismo" and described with "This is my description"
         Then a new meetup titled "Feminismo" should be in the schedule

