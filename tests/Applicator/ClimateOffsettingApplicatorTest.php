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

    /**
     * @test
     */
    public function it_uses_cart_context_if_no_order_is_given(): void
    {
        $order = new Order();

        $cartContext = new class($order) implements CartContextInterface {
            private Order $order;

            public function __construct(Order $order)
            {
                $this->order = $order;
            }

            public function getCart(): OrderInterface
            {
                return $this->order;
            }
        };

        $orderProcessor = $this->prophesize(OrderProcessorInterface::class);
        $orderProcessor->process($order)->shouldBeCalled();

        $orderManager = $this->prophesize(ObjectManager::class);
        $orderManager->flush()->shouldBeCalled();

        $applicator = new ClimateOffsettingApplicator($cartContext, $orderProcessor->reveal(), $orderManager->reveal());
        $applicator->applyClimateOffsetting(true);
        self::assertTrue($order->isClimateOffsetting());
    }
}
