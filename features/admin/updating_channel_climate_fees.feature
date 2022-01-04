@managing_channel_climate_fees
Feature: Updating channel climate fees
  In order to manage the climate fees that can be applied to a channel
  As an Administrator
  I want to be able to update a channel climate fees

  Background:
    Given the store operates on a single channel in "United States"
    And I am logged in as an administrator
    And the store has a climate fee of "$0.50"

  @ui @api
  Scenario: Updating channel climate fees
    Given I want to update this channel climate fee
    When I set fees to "$5.00"
    And I update it
    Then I should be notified that it has been successfully edited
    And I should see 1 channel climate fees in the list
    And it should be worth "$5.00"
