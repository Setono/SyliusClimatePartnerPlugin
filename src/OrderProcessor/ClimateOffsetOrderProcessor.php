<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\OrderProcessor;

use Psr\Log\LoggerInterface;
use Setono\SyliusClimatePartnerPlugin\Exception\OrderIsNotExpectedTypeException;
use Setono\SyliusClimatePartnerPlugin\Model\AdjustmentInterface;
use Setono\SyliusClimatePartnerPlugin\Model\OrderInterface;
use Setono\SyliusClimatePartnerPlugin\Repository\ChannelClimateFeeRepositoryInterface;
use Sylius\Component\Currency\Converter\CurrencyConverterInterface;
use Sylius\Component\Order\Factory\AdjustmentFactoryInterface;
use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ClimateOffsetOrderProcessor implements OrderProcessorInterface
{
    private ChannelClimateFeeRepositoryInterface $channelClimateFeeRepository;

    private CurrencyConverterInterface $currencyConverter;

    private AdjustmentFactoryInterface $adjustmentFactory;

    private TranslatorInterface $translator;

    private LoggerInterface $logger;

    public function __construct(
        ChannelClimateFeeRepositoryInterface $channelClimateFeeRepository,
        CurrencyConverterInterface $currencyConverter,
        AdjustmentFactoryInterface $adjustmentFactory,
        TranslatorInterface $translator,
        LoggerInterface $logger
    ) {
        $this->channelClimateFeeRepository = $channelClimateFeeRepository;
        $this->currencyConverter = $currencyConverter;
        $this->adjustmentFactory = $adjustmentFactory;
        $this->translator = $translator;
        $this->logger = $logger;
    }

    /**
     * @param BaseOrderInterface|OrderInterface $order
     */
    public function process(BaseOrderInterface $order): void
    {
        OrderIsNotExpectedTypeException::assert($order);

        $order->removeAdjustmentsRecursively(AdjustmentInterface::CLIMATE_OFFSET_ADJUSTMENT);

        if (!$order->isClimateOffsetting()) {
            return;
        }

        $channel = $order->getChannel();
        if (null === $channel) {
            return;
        }

        $baseCurrency = $channel->getBaseCurrency();
        if (null === $baseCurrency) {
            return;
        }

        $baseCurrencyCode = $baseCurrency->getCode();
        if (null === $baseCurrencyCode) {
            return;
        }

        $currencyCode = $order->getCurrencyCode();
        if (null === $currencyCode) {
            return;
        }

        $channelClimateFee = $this->channelClimateFeeRepository->findOneByChannel($channel);
        if (null === $channelClimateFee) {
            $this->logger->error(sprintf(
                'No climate fee set for channel %s. Go to Sylius administration > Climate Partner > Create to add one.',
                (string) $channel->getName()
            ));

            return;
        }

        $fee = $this->currencyConverter->convert((int) $channelClimateFee->getFee(), $baseCurrencyCode, $currencyCode);

        $adjustment = $this->adjustmentFactory->createWithData(
            AdjustmentInterface::CLIMATE_OFFSET_ADJUSTMENT,
            $this->translator->trans('setono_sylius_climate_partner.ui.climate_offset_adjustment_label'),
            $fee
        );

        $order->addAdjustment($adjustment);
    }
}
