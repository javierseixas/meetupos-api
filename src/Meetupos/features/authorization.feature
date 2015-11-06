@bdd
Feature: Authorization to the system
    # Web Administrator point of view
    As a web administrator
    I want users to be authenticated and authorized
    In order to allow entrance to a privacy area only to users that have them
    # User point of view
    As a visitor
    I want to be able to be authenticated
    In order to have access to a privacy area

    Scenario: User authenticated correctly
        Given an account with username as "javierseixas" and password "pass"
         When I give my credentials as username "javierseixas" and password "pass" to the system
         Then I am authenticated by the system

    Scenario: User not authenticated
        Given an account with username as "javierseixas" and password "pass"
         When I give my credentials as username "javierseixas" and password "wrongpass" to the system
         Then I am refused by the system