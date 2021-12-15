<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Unit\Model;

use PHPUnit\Framework\TestCase;
use Setono\SyliusClimatePartnerPlugin\Model\ChannelClimateFee;
use Setono\SyliusClimatePartnerPlugin\Model\ChannelClimateFeeInterface;
use Sylius\Component\Core\Model\Channel;

/**
 * @covers \Setono\SyliusClimatePartnerPlugin\Model\ChannelClimateFee
 */
final class ChannelClimateFeeTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_a_channel_climate_fee(): void
    {
        $obj = new ChannelClimateFee();
        self::assertInstanceOf(ChannelClimateFeeInterface::class, $obj);
    }

    /**
     * @test
     */
    public function it_has_sane_defaults(): void
    {
        $obj = new ChannelClimateFee();
        self::assertNull($obj->getId());
        self::assertNull($obj->getChannel());
        self::assertNull($obj->getFee());
    }

    /**
     * @test
     */
    public function it_mutates(): void
    {
        $channel = new Channel();
        $obj = new ChannelClimateFee();
        $obj->setChannel($channel);
        $obj->setFee(100);

        self::assertSame($channel, $obj->getChannel());
        self::assertSame(100, $obj->getFee());
    }
}
