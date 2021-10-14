<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Api\Handler;

use Setono\SyliusClimatePartnerPlugin\Api\Command\ApplyClimateOffset;
use Setono\SyliusClimatePartnerPlugin\Applicator\ClimateOffsettingApplicatorInterface;
use Sylius\Component\Order\Repository\OrderRepositoryInterface;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ApplyClimateOffsetHandler implements MessageHandlerInterface
{
    private ClimateOffsettingApplicatorInterface $climateOffsettingApplicator;

    private OrderRepositoryInterface $orderRepository;

    public function __construct(ClimateOffsettingApplicatorInterface $climateOffsettingApplicator, OrderRepositoryInterface $orderRepository)
    {
        $this->climateOffsettingApplicator = $climateOffsettingApplicator;
        $this->orderRepository = $orderRepository;
    }

    public function __invoke(ApplyClimateOffset $message): void
    {
        $order = $this->orderRepository->findOneByTokenValue($message->getOrderTokenValue());
        if(null === $order) {
            throw new UnrecoverableMessageHandlingException(sprintf('Order with token %s does not exist', $message->getOrderTokenValue()));
        }

        $this->climateOffsettingApplicator->applyClimateOffsetting(true, $order);
    }
}
