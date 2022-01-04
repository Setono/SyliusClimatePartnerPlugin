@managing_channel_climate_fees
Feature: Deleting channel climate fees
  In order to manage the climate fees that can be applied to a channel
  As an Administrator
  I want to be able to delete a channel climate fees

  Background:
    Given the store operates on a single channel in "United States"
    And I am logged in as an administrator
    And the store has a climate fee of "$0.50"

  @ui @api
  Scenario: Deleting channel climate fees
    When I delete it
    Then I should be notified that it has been successfully deleted
    And I should see 0 channel climate fees in the list
