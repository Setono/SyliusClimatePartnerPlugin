<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Unit\Controller\Action;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Setono\SyliusClimatePartnerPlugin\Applicator\ClimateOffsettingApplicatorInterface;
use Setono\SyliusClimatePartnerPlugin\Controller\Action\AbstractClimateOffsetAction;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractClimateOffsetActionTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_applies(): void
    {
        $urlGenerator = $this->prophesize(UrlGeneratorInterface::class);
        $urlGenerator->generate('sylius_shop_cart_summary')->willReturn('/en_US/cart/');

        $climateOffsettingApplicator = $this->prophesize(ClimateOffsettingApplicatorInterface::class);
        $climateOffsettingApplicator->applyClimateOffsetting($this->getExpectedClimateOffsettingValue())->shouldBeCalled();

        $request = new Request();
        $action = $this->getAction($urlGenerator->reveal(), $climateOffsettingApplicator->reveal());

        $response = $action->__invoke($request);
        self::assertInstanceOf(RedirectResponse::class, $response);
        self::assertSame('/en_US/cart/', $response->getTargetUrl());
    }

    /**
     * @test
     */
    public function it_redirects_to_referrer(): void
    {
        $urlGenerator = $this->prophesize(UrlGeneratorInterface::class);
        $urlGenerator->generate('sylius_shop_cart_summary')->willReturn('/en_US/cart/');

        $climateOffsettingApplicator = $this->prophesize(ClimateOffsettingApplicatorInterface::class);
        $climateOffsettingApplicator->applyClimateOffsetting($this->getExpectedClimateOffsettingValue())->shouldBeCalled();

        $request = new Request([], [], [], [], [], ['HTTP_REFERER' => '/']);
        $action = $this->getAction($urlGenerator->reveal(), $climateOffsettingApplicator->reveal());

        $response = $action->__invoke($request);
        self::assertInstanceOf(RedirectResponse::class, $response);
        self::assertSame('/', $response->getTargetUrl());
    }

    abstract protected function getAction(
        UrlGeneratorInterface $urlGenerator,
        ClimateOffsettingApplicatorInterface $climateOffsettingApplicator
    ): AbstractClimateOffsetAction;

    abstract protected function getExpectedClimateOffsettingValue(): bool;
}
