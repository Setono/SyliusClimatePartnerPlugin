<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Applicator;

use Sylius\Component\Order\Model\OrderInterface;

interface ClimateOffsettingApplicatorInterface
{
    /**
     * Should activate/apply climate offsetting on the order
     *
     * @param OrderInterface|null $order if not order is provided, use the order from cart context
     */
    public function applyClimateOffsetting(bool $value, OrderInterface $order = null): void;
}
