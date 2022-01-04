<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Setono\SyliusClimatePartnerPlugin\Model\ChannelClimateFeeInterface;
use Tests\Setono\SyliusClimatePartnerPlugin\Behat\Page\Admin\CreatePageInterface;
use Tests\Setono\SyliusClimatePartnerPlugin\Behat\Page\Admin\IndexPageInterface;
use Tests\Setono\SyliusClimatePartnerPlugin\Behat\Page\Admin\UpdatePageInterface;
use Webmozart\Assert\Assert;

final class ChannelClimateFeesContext implements Context
{
    private IndexPageInterface $indexPage;

    private CreatePageInterface $createPage;

    private UpdatePageInterface $updatePage;

    public function __construct(
        IndexPageInterface $indexPage,
        CreatePageInterface $createPage,
        UpdatePageInterface $updatePage
    ) {
        $this->indexPage = $indexPage;
        $this->createPage = $createPage;
        $this->updatePage = $updatePage;
    }

    /**
     * @When I want to browse channel climate fees
     */
    public function iBrowseChannelClimateFees(): void
    {
        $this->indexPage->open();
    }

    /**
     * @Then I should see :numberOfChannelClimateFees channel climate fees in the list
     */
    public function iShouldSeeChannelClimateFeesInTheList(int $numberOfChannelClimateFees = 1): void
    {
        Assert::same($this->indexPage->countItems(), $numberOfChannelClimateFees);
    }

    /**
     * @Given I want to add a new channel climate fees
     */
    public function iWantToCreateNewChannelClimateFees(): void
    {
        $this->createPage->open();
    }

    /**
     * @Given /^I want to update (this channel climate fee)$/
     */
    public function iWantToUpdateThisChannelClimateFee(ChannelClimateFeeInterface $channelClimateFee): void
    {
        $this->updatePage->open(['id' => $channelClimateFee->getId()]);
    }

    /**
     * @When I select channel :channelCode
     */
    public function iSelectChannel(string $channelCode): void
    {
        $this->createPage->chooseChannel($channelCode);
    }

    /**
     * @When /^I set fees to ("[^"]+")$/
     */
    public function iSpecifyItsFees(int $fees): void
    {
        $this->createPage->specifyFees($fees);
    }

    /**
     * @When I add it
     */
    public function iAddIt(): void
    {
        $this->createPage->create();
    }

    /**
     * @When I update it
     */
    public function iUpdateIt(): void
    {
        $this->updatePage->saveChanges();
    }

    /**
     * @When /^I delete (it)$/
     */
    public function iDeleteIt(ChannelClimateFeeInterface $channelClimateFee): void
    {
        $channel = $channelClimateFee->getChannel();
        if (null === $channel) {
            throw new \LogicException('A channel was expected');
        }

        $this->indexPage->open();
        $this->indexPage->deleteResourceOnPage([
            'channel' => $channel->getName(),
            'fee' => $channelClimateFee->getFee(),
        ]);
    }

    /**
     * @Then /^(it) should be worth ("[^"]+")$/
     */
    public function theChannelClimateFeeShouldWorth(ChannelClimateFeeInterface $channelClimateFee, int $fee): void
    {
        $this->updatePage->open(['id' => $channelClimateFee->getId()]);
        Assert::same($fee, (int) $this->updatePage->getFees());
    }
}
