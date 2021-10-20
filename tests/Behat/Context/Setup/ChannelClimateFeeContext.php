<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Setono\SyliusClimatePartnerPlugin\Model\ChannelClimateFeeInterface;
use Setono\SyliusClimatePartnerPlugin\Repository\ChannelClimateFeeRepositoryInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class ChannelClimateFeeContext implements Context
{
    private SharedStorageInterface $sharedStorage;

    private FactoryInterface $channelClimateFeeFactory;

    private ChannelClimateFeeRepositoryInterface $channelClimateFeeRepository;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        FactoryInterface $channelClimateFeeFactory,
        ChannelClimateFeeRepositoryInterface $channelClimateFeeRepository
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->channelClimateFeeFactory = $channelClimateFeeFactory;
        $this->channelClimateFeeRepository = $channelClimateFeeRepository;
    }

    /**
     * @Given /^the store has a climate fee of ("[^"]+")$/
     */
    public function theStoreHasClimateFeeForChannel(int $fee): void
    {
        /** @var ChannelInterface $channel */
        $channel = $this->sharedStorage->get('channel');

        /** @var ChannelClimateFeeInterface $climateFee */
        $climateFee = $this->channelClimateFeeFactory->createNew();
        $climateFee->setFee($fee);
        $climateFee->setChannel($channel);

        $this->channelClimateFeeRepository->add($climateFee);
    }
}
