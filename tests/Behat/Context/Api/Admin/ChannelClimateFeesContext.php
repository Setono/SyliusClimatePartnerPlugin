<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Behat\Context\Api\Admin;

use ApiPlatform\Core\Api\IriConverterInterface;
use Behat\Behat\Context\Context;
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
     * @When /^I select (channel "([^"]+)")$/
     */
    public function iChooseChannel(ChannelInterface $channel): void
    {
        $this->client->addRequestData('channel', $this->iriConverter->getIriFromItem($channel));
    }

    /**
     * @When I set fees to :fees
     */
    public function iSetFees(string $fees): void
    {
        $this->client->addRequestData('fee', (int) $fees);
    }

    /**
     * @When I add it
     */
    public function iAddIt(): void
    {
        $this->client->create();
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
     * @Then I should see :amount channel climate fees in the list
     */
    public function thereShouldBeXChannelClimateFee(int $amount): void
    {
        $this->client->index();
        Assert::eq(1, $this->responseChecker->countCollectionItems($this->client->getLastResponse()));
    }
}
