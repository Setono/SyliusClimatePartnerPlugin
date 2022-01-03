<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Behat\Context\Ui\Admin;

use Behat\Behat\Context\Context;
use Tests\Setono\SyliusClimatePartnerPlugin\Behat\Page\Admin\CreatePageInterface;
use Tests\Setono\SyliusClimatePartnerPlugin\Behat\Page\Admin\IndexPageInterface;
use Webmozart\Assert\Assert;

final class ChannelClimateFeesContext implements Context
{
    private IndexPageInterface $indexPage;

    private CreatePageInterface $createPage;

    public function __construct(IndexPageInterface $indexPage, CreatePageInterface $createPage)
    {
        $this->indexPage = $indexPage;
        $this->createPage = $createPage;
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
     * @When I select channel :channelCode
     */
    public function iSelectChannel(string $channelCode): void
    {
        $this->createPage->chooseChannel($channelCode);
    }

    /**
     * @When I set fees to :fees
     */
    public function iSpecifyItsFees(string $fees): void
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
}
