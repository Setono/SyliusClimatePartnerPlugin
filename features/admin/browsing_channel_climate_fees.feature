@managing_channel_climate_fees
Feature: Browsing channel climate fees
  In order to manage the climate fees that can be applied to a channel
  As an Administrator
  I want to be able to browse channel climate fees

  Background:
    Given the store operates on a single channel in "United States"
    And the store has a climate fee of "$0.50"
    And I am logged in as an administrator

  @ui @api
  Scenario: Browsing defined channel climate fees
    When I want to browse channel climate fees
    Then I should see 1 channel climate fees in the list
