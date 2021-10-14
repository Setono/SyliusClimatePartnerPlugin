<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Model;

use PHPUnit\Framework\TestCase;
use Setono\SyliusClimatePartnerPlugin\Model\AdjustmentInterface;
use Setono\SyliusClimatePartnerPlugin\Model\OrderInterface;
use Setono\SyliusClimatePartnerPlugin\Model\OrderTrait;
use Sylius\Component\Core\Model\Adjustment;
use Sylius\Component\Core\Model\Order;

/**
 * @covers \Setono\SyliusClimatePartnerPlugin\Model\OrderTrait
 */
final class OrderTraitTest extends TestCase
{
    /**
     * @test
     */
    public function it_has_sane_defaults(): void
    {
        $obj = $this->getOrder();
        self::assertFalse($obj->isClimateOffsetting());
        self::assertSame(0, $obj->getClimateOffsetTotal());
    }

    /**
     * @test
     */
    public function it_mutates(): void
    {
        $obj = $this->getOrder();
        $obj->setClimateOffsetting(true);

        self::assertTrue($obj->isClimateOffsetting());
    }

    /**
     * @test
     */
    public function it_returns_correct_climate_offset(): void
    {
        $adjustment = new Adjustment();
        $adjustment->setType(AdjustmentInterface::CLIMATE_OFFSET_ADJUSTMENT);
        $adjustment->setAmount(100);
        $obj = $this->getOrder();
        $obj->addAdjustment($adjustment);

        self::assertSame(100, $obj->getClimateOffsetTotal());
    }

    private function getOrder(): OrderInterface
    {
        return new class() extends Order implements OrderInterface {
            use OrderTrait;
        };
    }
}
