<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Api\Command;

use Sylius\Bundle\ApiBundle\Command\OrderTokenValueAwareInterface;

final class ApplyClimateOffset implements OrderTokenValueAwareInterface
{
    private ?string $orderTokenValue = null;

    public function getOrderTokenValue(): ?string
    {
        return $this->orderTokenValue;
    }

    public function setOrderTokenValue(?string $orderTokenValue): void
    {
        $this->orderTokenValue = $orderTokenValue;
    }
}
