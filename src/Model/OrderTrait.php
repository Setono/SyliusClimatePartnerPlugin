<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * @mixin OrderInterface
 */
trait OrderTrait
{
    /** @ORM\Column(type="boolean") */
    protected bool $climateOffsetting = false;

    public function isClimateOffsetting(): bool
    {
        return $this->climateOffsetting;
    }

    public function setClimateOffsetting(bool $climateOffsetting): void
    {
        $this->climateOffsetting = $climateOffsetting;
    }

    public function getClimateOffsetTotal(): int
    {
        return $this->getAdjustmentsTotal(AdjustmentInterface::CLIMATE_OFFSET_ADJUSTMENT);
    }
}
