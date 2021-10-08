<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Controller\Action;

final class ApplyClimateOffsetAction extends AbstractClimateOffsetAction
{
    protected function getValue(): bool
    {
        return true;
    }
}
