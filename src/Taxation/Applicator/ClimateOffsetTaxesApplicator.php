<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Taxation\Applicator;

use Setono\SyliusClimatePartnerPlugin\Exception\OrderIsNotExpectedTypeException;
use Setono\SyliusClimatePartnerPlugin\Model\OrderInterface;
use Sylius\Component\Addressing\Model\ZoneInterface;
use Sylius\Component\Core\Model\AdjustmentInterface;
use Sylius\Component\Core\Model\OrderInterface as BaseOrderInterface;
use Sylius\Component\Core\Model\ShipmentInterface;
use Sylius\Component\Core\Taxation\Applicator\OrderTaxesApplicatorInterface;
use Sylius\Component\Order\Factory\AdjustmentFactoryInterface;
use Sylius\Component\Shipping\Model\ShippingMethodInterface;
use Sylius\Component\Taxation\Calculator\CalculatorInterface;
use Sylius\Component\Taxation\Model\TaxableInterface;
use Sylius\Component\Taxation\Model\TaxRateInterface;
use Sylius\Component\Taxation\Resolver\TaxRateResolverInterface;
use Webmozart\Assert\Assert;

final class ClimateOffsetTaxesApplicator implements OrderTaxesApplicatorInterface
{
    private CalculatorInterface $calculator;

    private AdjustmentFactoryInterface $adjustmentFactory;

    private TaxRateResolverInterface $taxRateResolver;

    public function __construct(
        CalculatorInterface $calculator,
        AdjustmentFactoryInterface $adjustmentFactory,
        TaxRateResolverInterface $taxRateResolver
    ) {
        $this->calculator = $calculator;
        $this->adjustmentFactory = $adjustmentFactory;
        $this->taxRateResolver = $taxRateResolver;
    }

    /**
     * @param BaseOrderInterface|OrderInterface $order
     */
    public function apply(BaseOrderInterface $order, ZoneInterface $zone): void
    {
        OrderIsNotExpectedTypeException::assert($order);

        $climateOffsetTotal = $order->getClimateOffsetTotal();
        if (0 === $climateOffsetTotal) {
            return;
        }

        // notice that we will use the same taxation strategy as shipments
        if (!$order->hasShipments()) {
            throw new \LogicException('Order should have at least one shipment.');
        }

        /** @var ShipmentInterface|false|mixed $shipment */
        $shipment = $order->getShipments()->first();
        Assert::isInstanceOf($shipment, ShipmentInterface::class);

        /** @var ShippingMethodInterface|TaxableInterface $shippingMethod */
        $shippingMethod = $shipment->getMethod();
        Assert::isInstanceOf($shippingMethod, TaxableInterface::class);

        $taxRate = $this->taxRateResolver->resolve($shippingMethod, ['zone' => $zone]);
        if (null === $taxRate) {
            return;
        }

        $taxAmount = (int) round($this->calculator->calculate($climateOffsetTotal, $taxRate));
        if (0 === $taxAmount) {
            return;
        }

        $this->addAdjustment($order, $taxAmount, $taxRate);
    }

    private function addAdjustment(
        OrderInterface $order,
        int $taxAmount,
        TaxRateInterface $taxRate
    ): void {
        $order->addAdjustment($this->adjustmentFactory->createWithData(
            AdjustmentInterface::TAX_ADJUSTMENT,
            (string) $taxRate->getLabel(),
            $taxAmount,
            $taxRate->isIncludedInPrice(),
            [
                'type' => 'Climate offset tax',
                'taxRateCode' => $taxRate->getCode(),
                'taxRateName' => $taxRate->getName(),
                'taxRateAmount' => $taxRate->getAmount(),
            ]
        ));
    }
}
