#feature search
Feature: search in the home page
In order to see information about clothes
As a visit user
I need to be able to search for a brand

Scenario: Searching for a particular brand
Given I am on the homepage
When I fill on "search" with the value "Zalora"
And I press enter
Then  I should see the word "Zalora"