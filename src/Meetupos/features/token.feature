Feature: Token
    As admin user
    In order to log into the app
    I need to be able to get a token

Scenario: I get a token successfully
    Given I prepare a GET request on "/users"
      And I specified the following request body:
        | email    | javier@meetupos.org |
        | password | pass |
     When I send the request
     Then I should receive a 200 response containing:
          """
            {
              "page": 1,
              "limit": 10,
              "pages": 1,
              "total": 0,
              "_links": {
                "self": {
                  "href": "/users/?page=1&limit=10"
                },
                "first": {
                  "href": "/users/?page=1&limit=10"
                },
                "last": {
                  "href": "/users/?page=1&limit=10"
                }
              },
              "_embedded": {
                "items": []
              }
            }
          """