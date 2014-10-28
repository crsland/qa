Feature: Search
  Test search functionality with valid and invalid query string

  @javascript @alice @ci
  Scenario: Valid search
    Given I search for "dresses"
    Then I should see products in catalog

  @javascript @alice @ci
  Scenario: Valid search without classifier
    Given I search for "kaftan"
    Then I should see products in catalog

  @javascript @alice @ci
  Scenario: Invalid search
    Given I search for "!@#$@#$@!%$#%#^%#%^"
    Then I should not see products in catalog
    And I should see "We couldn't find a match for"