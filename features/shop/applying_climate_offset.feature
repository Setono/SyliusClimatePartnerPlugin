@applying_climate_offset
Feature: Applying climate offset
  In order to pay something to help supporting actions for the planet
  As a Customer
  I want to add Climate offset to my cart

  Background:
    Given the store operates on a single channel in "United States"
    And the store has a product "PHP T-Shirt" priced at "$100.00"
    And the store has a climate fee of "$0.50"

  @ui @api
  Scenario: Applying climate offset
    Given I am a logged in customer
    And I have product "PHP T-Shirt" in the cart
    When I apply climate offset
    Then my cart total should be "$100.50"

  @ui @api
  Scenario: Removing climate offset
    Given I am a logged in customer
    And I have product "PHP T-Shirt" in the cart
    And I applied climate offset to my cart
    When I remove climate offset
    Then my cart total should be "$100.00"
