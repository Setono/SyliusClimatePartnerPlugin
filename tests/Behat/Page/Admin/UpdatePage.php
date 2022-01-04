<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Behat\Page\Admin;

use Sylius\Behat\Page\Admin\Crud\UpdatePage as CrudUpdatePage;

class UpdatePage extends CrudUpdatePage implements UpdatePageInterface
{
    public function specifyFees(int $fees): void
    {
        $this->getDocument()->fillField('Fee', $fees);
    }

    public function getFees(): string
    {
        return $this->getElement('fee')->getValue();
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'fee' => '#setono_sylius_climate_partner_channel_climate_fee_fee',
        ]);
    }
}
