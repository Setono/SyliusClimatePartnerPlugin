<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Behat\Context\Setup;

use Behat\Behat\Context\Context;
use Setono\SyliusClimatePartnerPlugin\Api\Command\ApplyClimateOffset;
use Sylius\Behat\Service\SharedStorageInterface;
use Sylius\Bundle\ApiBundle\Command\Cart\PickupCart;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Resource\Generator\RandomnessGeneratorInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class CartContext implements Context
{
    private SharedStorageInterface $sharedStorage;

    private MessageBusInterface $commandBus;

    private RandomnessGeneratorInterface $generator;

    public function __construct(
        SharedStorageInterface $sharedStorage,
        MessageBusInterface $commandBus,
        RandomnessGeneratorInterface $generator
    ) {
        $this->sharedStorage = $sharedStorage;
        $this->commandBus = $commandBus;
        $this->generator = $generator;
    }

    /**
     * @Given /^I applied climate offset to my (cart)$/
     */
    public function iAppliedClimateOffset(?string $tokenValue): void
    {
        $tokenValue = $tokenValue ?? $this->pickupCart();

        $message = new ApplyClimateOffset();
        $message->setOrderTokenValue($tokenValue);
        $this->commandBus->dispatch($message);
    }

    private function pickupCart(): string
    {
        $tokenValue = $this->generator->generateUriSafeString(10);

        /** @var ChannelInterface $channel */
        $channel = $this->sharedStorage->get('channel');
        $channelCode = $channel->getCode();

        $commandPickupCart = new PickupCart($tokenValue);
        $commandPickupCart->setChannelCode($channelCode);

        $this->commandBus->dispatch($commandPickupCart);

        $this->sharedStorage->set('cart_token', $tokenValue);

        return $tokenValue;
    }
}
