<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Applicator;

use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Setono\SyliusClimatePartnerPlugin\Applicator\ClimateOffsettingApplicator;
use Sylius\Component\Order\Context\CartContextInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Tests\Setono\SyliusClimatePartnerPlugin\Application\Model\Order;

/**
 * @covers \Setono\SyliusClimatePartnerPlugin\Applicator\ClimateOffsettingApplicator
 */
final class ClimateOffsettingApplicatorTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_applies(): void
    {
        $order = new Order();

        $cartContext = new class() implements CartContextInterface {
            public function getCart(): OrderInterface
            {
                return new Order();
            }
        };

        $orderProcessor = $this->prophesize(OrderProcessorInterface::class);
        $orderProcessor->process($order)->shouldBeCalled();

        $orderManager = $this->prophesize(ObjectManager::class);
        $orderManager->flush()->shouldBeCalled();

        $applicator = new ClimateOffsettingApplicator($cartContext, $orderProcessor->reveal(), $orderManager->reveal());
        $applicator->applyClimateOffsetting(true, $order);
        self::assertTrue($order->isClimateOffsetting());
    }
}
