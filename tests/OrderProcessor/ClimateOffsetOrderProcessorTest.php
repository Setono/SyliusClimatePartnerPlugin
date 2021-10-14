<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\OrderProcessor;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTrait;
use Psr\Log\LoggerInterface;
use Setono\SyliusClimatePartnerPlugin\Model\ChannelClimateFee;
use Setono\SyliusClimatePartnerPlugin\Model\OrderInterface;
use Setono\SyliusClimatePartnerPlugin\Model\OrderTrait;
use Setono\SyliusClimatePartnerPlugin\OrderProcessor\ClimateOffsetOrderProcessor;
use Setono\SyliusClimatePartnerPlugin\Repository\ChannelClimateFeeRepositoryInterface;
use Sylius\Component\Core\Model\Adjustment;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Currency\Converter\CurrencyConverterInterface;
use Sylius\Component\Currency\Model\Currency;
use Sylius\Component\Order\Factory\AdjustmentFactory;
use Sylius\Component\Resource\Factory\Factory;
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @covers \Setono\SyliusClimatePartnerPlugin\OrderProcessor\ClimateOffsetOrderProcessor
 */
final class ClimateOffsetOrderProcessorTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_adds_adjustment(): void
    {
        $baseCurrency = new Currency();
        $baseCurrency->setCode('USD');

        $channel = new Channel();
        $channel->setBaseCurrency($baseCurrency);

        $order = $this->getOrder();
        $order->setClimateOffsetting(true);
        $order->setChannel($channel);
        $order->setCurrencyCode('USD');

        $processor = $this->getOrderProcessor();
        $processor->process($order);

        self::assertSame(100, $order->getClimateOffsetTotal());
    }

    private function getOrder(): OrderInterface
    {
        return new class() extends Order implements OrderInterface {
            use OrderTrait;
        };
    }

    private function getOrderProcessor(): ClimateOffsetOrderProcessor
    {
        $channelClimateFee = new ChannelClimateFee();
        $channelClimateFee->setFee(100);

        $repository = $this->prophesize(ChannelClimateFeeRepositoryInterface::class);
        $repository->findOneByChannel(Argument::type(ChannelInterface::class))->willReturn($channelClimateFee);

        $currencyConverter = $this->prophesize(CurrencyConverterInterface::class);
        $currencyConverter->convert(100, 'USD', 'USD')->willReturn(100);

        $adjustmentFactory = new AdjustmentFactory(new Factory(Adjustment::class));

        $translator = $this->prophesize(TranslatorInterface::class);
        $translator->trans(Argument::type('string'))->willReturn('Climate offset');

        $logger = $this->prophesize(LoggerInterface::class);

        return new ClimateOffsetOrderProcessor(
            $repository->reveal(),
            $currencyConverter->reveal(),
            $adjustmentFactory,
            $translator->reveal(),
            $logger->reveal()
        );
    }
}
