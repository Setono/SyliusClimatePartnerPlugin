<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Behat\Page\Admin;

use Sylius\Behat\Page\Admin\Crud\UpdatePageInterface as CrudUpdatePageInterface;

interface UpdatePageInterface extends CrudUpdatePageInterface
{
    public function specifyFees(int $fees): void;

    public function getFees(): string;
}
