<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Api\Handler;

use Setono\SyliusClimatePartnerPlugin\Api\Command\RemoveClimateOffset;
use Setono\SyliusClimatePartnerPlugin\Applicator\ClimateOffsettingApplicatorInterface;
use Setono\SyliusClimatePartnerPlugin\Model\OrderInterface;
use function sprintf;
use Sylius\Component\Order\Repository\OrderRepositoryInterface;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class RemoveClimateOffsetHandler implements MessageHandlerInterface
{
    private ClimateOffsettingApplicatorInterface $climateOffsettingApplicator;

    private OrderRepositoryInterface $orderRepository;

    public function __construct(
        ClimateOffsettingApplicatorInterface $climateOffsettingApplicator,
        OrderRepositoryInterface $orderRepository
    ) {
        $this->climateOffsettingApplicator = $climateOffsettingApplicator;
        $this->orderRepository = $orderRepository;
    }

    public function __invoke(RemoveClimateOffset $message): OrderInterface
    {
        $orderTokenValue = $message->getOrderTokenValue();
        if (null === $orderTokenValue) {
            throw new UnrecoverableMessageHandlingException('Order token value can not be null');
        }
        /**
         * @var OrderInterface|null $order
         *
         * Even if we use the correct interface, psalm still throws the deprecated method exception
         * @psalm-suppress DeprecatedMethod
         */
        $order = $this->orderRepository->findCartByTokenValue($orderTokenValue);
        if (null === $order) {
            throw new UnrecoverableMessageHandlingException(sprintf('Order with token %s does not exist', $orderTokenValue));
        }

        $this->climateOffsettingApplicator->applyClimateOffsetting(false, $order);

        return $order;
    }
}
