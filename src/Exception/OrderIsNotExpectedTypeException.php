<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Exception;

use RuntimeException;
use Setono\SyliusClimatePartnerPlugin\Model\OrderInterface;
use Setono\SyliusClimatePartnerPlugin\Model\OrderTrait;
use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;

final class OrderIsNotExpectedTypeException extends RuntimeException
{
    /**
     * @psalm-assert OrderInterface $order
     *
     * @throws self
     */
    public static function assert(BaseOrderInterface $order): void
    {
        if (!$order instanceof OrderInterface) {
            throw new self(sprintf(
                'The order is not implementing the interface %s. You can use the trait %s to make it easier for yourself.',
                BaseOrderInterface::class,
                OrderTrait::class
            ));
        }
    }
}
