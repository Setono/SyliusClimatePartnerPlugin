<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Taxation\Applicator;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Setono\SyliusClimatePartnerPlugin\Model\AdjustmentInterface;
use Setono\SyliusClimatePartnerPlugin\Model\OrderInterface;
use Setono\SyliusClimatePartnerPlugin\Model\OrderTrait;
use Setono\SyliusClimatePartnerPlugin\Taxation\Applicator\ClimateOffsetTaxesApplicator;
use Sylius\Component\Addressing\Model\Zone;
use Sylius\Component\Core\Model\Adjustment;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Core\Model\Shipment;
use Sylius\Component\Core\Model\ShippingMethod;
use Sylius\Component\Core\Model\TaxRate;
use Sylius\Component\Order\Factory\AdjustmentFactory;
use Sylius\Component\Resource\Factory\Factory;
use Sylius\Component\Taxation\Calculator\DefaultCalculator;
use Sylius\Component\Taxation\Resolver\TaxRateResolverInterface;

/**
 * @covers \Setono\SyliusClimatePartnerPlugin\Taxation\Applicator\ClimateOffsetTaxesApplicator
 */
final class ClimateOffsetTaxesApplicatorTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_applies_tax(): void
    {
        $zone = new Zone();

        $calculator = new DefaultCalculator();
        $adjustmentFactory = new AdjustmentFactory(new Factory(Adjustment::class));

        $shippingMethod = new ShippingMethod();

        $shipment = new Shipment();
        $shipment->setMethod($shippingMethod);

        $order = $this->getOrder();
        $order->addShipment($shipment);
        $order->addAdjustment($adjustmentFactory->createWithData(AdjustmentInterface::CLIMATE_OFFSET_ADJUSTMENT, 'Climate offset', 100));

        $taxRate = new TaxRate();
        $taxRate->setAmount(0.2);

        $taxRateResolver = $this->prophesize(TaxRateResolverInterface::class);
        $taxRateResolver->resolve($shippingMethod, ['zone' => $zone])->willReturn($taxRate);

        $applicator = new ClimateOffsetTaxesApplicator($calculator, $adjustmentFactory, $taxRateResolver->reveal());
        $applicator->apply($order, $zone);

        self::assertSame(20, $order->getTaxTotal());
    }

    private function getOrder(): OrderInterface
    {
        return new class() extends Order implements OrderInterface {
            use OrderTrait;
        };
    }
}
