<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Behat\Page\Shop\Cart;

use Sylius\Behat\Page\Shop\Cart\SummaryPage as BaseSummaryPage;

final class SummaryPage extends BaseSummaryPage implements SummaryPageInterface
{
    public function applyClimateOffset(): void
    {
        $this->getElement('apply_climate_offset_button')->press();
    }

    public function removeClimateOffset(): void
    {
        $this->getElement('remove_climate_offset_button')->press();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'apply_climate_offset_button' => 'a[data-test-setono-sylius-climate-partner-apply-offset-to-order]',
            'remove_climate_offset_button' => 'a[data-test-setono-sylius-climate-partner-remove-offset-from-order]',
        ]);
    }
}
