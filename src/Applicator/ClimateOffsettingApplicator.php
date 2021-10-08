<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Applicator;

use Doctrine\Persistence\ObjectManager;
use Setono\SyliusClimatePartnerPlugin\Exception\OrderIsNotExpectedTypeException;
use Setono\SyliusClimatePartnerPlugin\Model\OrderInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Sylius\Component\Order\Model\OrderInterface as BaseOrderInterface;
use Sylius\Component\Order\Processor\OrderProcessorInterface;

final class ClimateOffsettingApplicator implements ClimateOffsettingApplicatorInterface
{
    private CartContextInterface $cartContext;

    private OrderProcessorInterface $orderProcessor;

    private ObjectManager $orderManager;

    public function __construct(CartContextInterface $cartContext, OrderProcessorInterface $orderProcessor, ObjectManager $orderManager)
    {
        $this->cartContext = $cartContext;
        $this->orderProcessor = $orderProcessor;
        $this->orderManager = $orderManager;
    }

    /**
     * @param BaseOrderInterface|OrderInterface $order
     */
    public function applyClimateOffsetting(bool $value, BaseOrderInterface $order = null): void
    {
        if (null === $order) {
            $order = $this->cartContext->getCart();
        }

        OrderIsNotExpectedTypeException::assert($order);

        $order->setClimateOffsetting($value);

        $this->orderProcessor->process($order);
        $this->orderManager->flush();
    }
}
