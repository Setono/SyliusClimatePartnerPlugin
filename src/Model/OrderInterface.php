<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Model;

use Sylius\Component\Core\Model\OrderInterface as BaseOrderInterface;

interface OrderInterface extends BaseOrderInterface
{
    /**
     * Returns true if this order is climate offset
     */
    public function isClimateOffsetting(): bool;

    /**
     * Set whether this order should be climate offset or not
     */
    public function setClimateOffsetting(bool $climateOffsetting): void;

    /**
     * Returns the total climate offset amount for this order
     */
    public function getClimateOffsetTotal(): int;
}
