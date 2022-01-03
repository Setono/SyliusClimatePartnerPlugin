<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Behat\Page\Admin;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface as CrudCreatePageInterface;

interface CreatePageInterface extends CrudCreatePageInterface
{
    public function chooseChannel(string $channelCode): void;

    public function specifyFees(string $fees): void;
}
