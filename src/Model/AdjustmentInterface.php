<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Model;

use Sylius\Component\Core\Model\AdjustmentInterface as BaseAdjustmentInterface;

interface AdjustmentInterface extends BaseAdjustmentInterface
{
    public const CLIMATE_OFFSET_ADJUSTMENT = 'climate_offset';
}
