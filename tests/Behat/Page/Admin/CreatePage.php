<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Behat\Page\Admin;

use Sylius\Behat\Page\Admin\Crud\CreatePage as CrudCreatePage;

class CreatePage extends CrudCreatePage implements CreatePageInterface
{
    public function chooseChannel(string $channelCode): void
    {
        $this->getElement('channel')->selectOption($channelCode);
    }

    public function specifyFees(int $fees): void
    {
        $this->getDocument()->fillField('Fee', $fees);
    }

    protected function getDefinedElements(): array
    {
        return array_merge(parent::getDefinedElements(), [
            'channel' => '#setono_sylius_climate_partner_channel_climate_fee_channel',
        ]);
    }
}
