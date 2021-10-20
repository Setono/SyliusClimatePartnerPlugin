<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Behat\Context\Ui\Shop;

use Behat\Behat\Context\Context;
use Tests\Setono\SyliusClimatePartnerPlugin\Behat\Page\Shop\Cart\SummaryPageInterface;

final class CartContext implements Context
{
    private SummaryPageInterface $summaryPage;

    public function __construct(SummaryPageInterface $summaryPage)
    {
        $this->summaryPage = $summaryPage;
    }

    /**
     * @When I apply climate offset
     * @Given I applied climate offset to my cart
     */
    public function iApplyClimateOffset(): void
    {
        $this->summaryPage->applyClimateOffset();
    }

    /**
     * @When I remove climate offset
     */
    public function iRemoveClimateOffset(): void
    {
        $this->summaryPage->removeClimateOffset();
    }
}
