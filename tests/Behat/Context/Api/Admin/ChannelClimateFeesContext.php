<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Behat\Context\Api\Admin;

use ApiPlatform\Core\Api\IriConverterInterface;
use Behat\Behat\Context\Context;
use Setono\SyliusClimatePartnerPlugin\Model\ChannelClimateFeeInterface;
use Sylius\Behat\Client\ApiClientInterface;
use Sylius\Behat\Client\ResponseCheckerInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Webmozart\Assert\Assert;

final class ChannelClimateFeesContext implements Context
{
    private ApiClientInterface $client;

    private ResponseCheckerInterface $responseChecker;

    private IriConverterInterface $iriConverter;

    public function __construct(
        ApiClientInterface $client,
        ResponseCheckerInterface $responseChecker,
        IriConverterInterface $iriConverter
    ) {
        $this->client = $client;
        $this->responseChecker = $responseChecker;
        $this->iriConverter = $iriConverter;
    }

    /**
     * @Given I want to browse channel climate fees
     */
    public function iWantToBrowseChannelClimateFee(): void
    {
        $this->client->index();
    }

    /**
     * @Given I want to add a new channel climate fees
     */
    public function iWantToAddNewChannelClimateFee(): void
    {
        $this->client->buildCreateRequest();
    }

    /**
     * @Given /^I want to update (this channel climate fee)$/
     */
    public function iWantToUpdateThisChannelClimateFee(ChannelClimateFeeInterface $channelClimateFee): void
    {
        $this->client->buildUpdateRequest((string) $channelClimateFee->getId());
    }

    /**
     * @When /^I select (channel "([^"]+)")$/
     */
    public function iChooseChannel(ChannelInterface $channel): void
    {
        $this->client->addRequestData('channel', $this->iriConverter->getIriFromItem($channel));
    }

    /**
     * @When /^I set fees to ("[^"]+")$/
     */
    public function iSetFees(int $fees): void
    {
        $this->client->addRequestData('fee', $fees);
    }

    /**
     * @When I add it
     */
    public function iAddIt(): void
    {
        $this->client->create();
    }

    /**
     * @When I update it
     */
    public function iUpdateIt(): void
    {
        $this->client->update();
    }

    /**
     * @When /^I delete (it)$/
     */
    public function iDeleteIt(ChannelClimateFeeInterface $channelClimateFee): void
    {
        $this->client->delete((string) $channelClimateFee->getId());
    }

    /**
     * @Then I should be notified that it has been successfully created
     */
    public function iShouldBeNotifiedThatItHasBeenSuccessfullyCreated(): void
    {
        Assert::true(
            $this->responseChecker->isCreationSuccessful($this->client->getLastResponse()),
            'Channel climate fee could not be created'
        );
    }

    /**
     * @Then I should be notified that it has been successfully edited
     */
    public function iShouldBeNotifiedThatItHasBeenSuccessfullyUpdated(): void
    {
        Assert::true(
            $this->responseChecker->isUpdateSuccessful($this->client->getLastResponse()),
            'Channel climate fee could not be updated'
        );
    }

    /**
     * @Then I should be notified that it has been successfully deleted
     */
    public function iShouldBeNotifiedThatItHasBeenSuccessfullyDeleted(): void
    {
        Assert::true(
            $this->responseChecker->isDeletionSuccessful($this->client->getLastResponse()),
            'Channel climate fee could not be deleted'
        );
    }

    /**
     * @Then I should see :amount channel climate fees in the list
     */
    public function thereShouldBeXChannelClimateFee(int $amount): void
    {
        $this->client->index();
        Assert::eq($amount, $this->responseChecker->countCollectionItems($this->client->getLastResponse()));
    }

    /**
     * @Then /^(it) should be worth ("[^"]+")$/
     */
    public function theChannelClimateFeeShouldWorth(ChannelClimateFeeInterface $channelClimateFee, int $fee): void
    {
        $this->client->show((string) $channelClimateFee->getId());
        Assert::same($fee, $this->responseChecker->getValue($this->client->getLastResponse(), 'fee'));
    }
}
