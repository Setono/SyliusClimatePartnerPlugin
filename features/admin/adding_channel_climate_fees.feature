@managing_channel_climate_fees
Feature: Adding channel climate fees
  In order to manage the climate fees that can be applied to a channel
  As an Administrator
  I want to be able to add a new channel climate fees

  Background:
    Given the store operates on a single channel in "United States"
    And I am logged in as an administrator

  @ui @api
  Scenario: Adding channel climate fees
    Given I want to add a new channel climate fees
    When I select channel "United States"
    And I set fees to "$0.50"
    And I add it
    Then I should be notified that it has been successfully created
    And I should see 1 channel climate fees in the list
