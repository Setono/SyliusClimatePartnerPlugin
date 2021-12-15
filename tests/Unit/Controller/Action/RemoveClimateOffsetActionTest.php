<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Unit\Controller\Action;

use Setono\SyliusClimatePartnerPlugin\Applicator\ClimateOffsettingApplicatorInterface;
use Setono\SyliusClimatePartnerPlugin\Controller\Action\AbstractClimateOffsetAction;
use Setono\SyliusClimatePartnerPlugin\Controller\Action\RemoveClimateOffsetAction;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @covers \Setono\SyliusClimatePartnerPlugin\Controller\Action\AbstractClimateOffsetAction
 * @covers \Setono\SyliusClimatePartnerPlugin\Controller\Action\RemoveClimateOffsetAction
 */
final class RemoveClimateOffsetActionTest extends AbstractClimateOffsetActionTest
{
    protected function getAction(
        UrlGeneratorInterface $urlGenerator,
        ClimateOffsettingApplicatorInterface $climateOffsettingApplicator
    ): AbstractClimateOffsetAction {
        return new RemoveClimateOffsetAction($urlGenerator, $climateOffsettingApplicator);
    }

    protected function getExpectedClimateOffsettingValue(): bool
    {
        return false;
    }
}
