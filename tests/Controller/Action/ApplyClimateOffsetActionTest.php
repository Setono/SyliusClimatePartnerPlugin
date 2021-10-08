<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Controller\Action;

use Setono\SyliusClimatePartnerPlugin\Applicator\ClimateOffsettingApplicatorInterface;
use Setono\SyliusClimatePartnerPlugin\Controller\Action\AbstractClimateOffsetAction;
use Setono\SyliusClimatePartnerPlugin\Controller\Action\ApplyClimateOffsetAction;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @covers \Setono\SyliusClimatePartnerPlugin\Controller\Action\AbstractClimateOffsetAction
 * @covers \Setono\SyliusClimatePartnerPlugin\Controller\Action\ApplyClimateOffsetAction
 */
final class ApplyClimateOffsetActionTest extends AbstractClimateOffsetActionTest
{
    protected function getAction(
        UrlGeneratorInterface $urlGenerator,
        ClimateOffsettingApplicatorInterface $climateOffsettingApplicator
    ): AbstractClimateOffsetAction {
        return new ApplyClimateOffsetAction($urlGenerator, $climateOffsettingApplicator);
    }

    protected function getExpectedClimateOffsettingValue(): bool
    {
        return true;
    }
}
