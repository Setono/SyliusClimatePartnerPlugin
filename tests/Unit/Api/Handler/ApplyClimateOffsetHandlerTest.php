<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Unit\Api\Handler;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Setono\SyliusClimatePartnerPlugin\Api\Command\ApplyClimateOffset;
use Setono\SyliusClimatePartnerPlugin\Api\Handler\ApplyClimateOffsetHandler;
use Setono\SyliusClimatePartnerPlugin\Applicator\ClimateOffsettingApplicatorInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Tests\Setono\SyliusClimatePartnerPlugin\Application\Model\Order;

final class ApplyClimateOffsetHandlerTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_is_a_message_handler(): void
    {
        $climateOffsettingApplicator = $this->prophesize(ClimateOffsettingApplicatorInterface::class);
        $orderRepository = $this->prophesize(OrderRepositoryInterface::class);
        $handler = new ApplyClimateOffsetHandler($climateOffsettingApplicator->reveal(), $orderRepository->reveal());

        $this->assertInstanceOf(MessageHandlerInterface::class, $handler);
    }

    /**
     * @test
     */
    public function it_applies_climate_offsetting_to_an_order(): void
    {
        $order = new Order();
        $message = new ApplyClimateOffset();
        $message->setOrderTokenValue('token_value');

        $climateOffsettingApplicator = $this->prophesize(ClimateOffsettingApplicatorInterface::class);
        $orderRepository = $this->prophesize(OrderRepositoryInterface::class);

        $orderRepository->findCartByTokenValue('token_value')
            ->willReturn($order);
        $climateOffsettingApplicator->applyClimateOffsetting(true, $order)
            ->shouldBeCalled();

        $handler = new ApplyClimateOffsetHandler($climateOffsettingApplicator->reveal(), $orderRepository->reveal());
        $handler($message);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_no_token_is_provided(): void
    {
        $message = new ApplyClimateOffset();

        $climateOffsettingApplicator = $this->prophesize(ClimateOffsettingApplicatorInterface::class);
        $orderRepository = $this->prophesize(OrderRepositoryInterface::class);

        $this->expectException(UnrecoverableMessageHandlingException::class);

        $handler = new ApplyClimateOffsetHandler($climateOffsettingApplicator->reveal(), $orderRepository->reveal());
        $handler($message);
    }

    /**
     * @test
     */
    public function it_throws_an_exception_if_order_is_not_found(): void
    {
        $message = new ApplyClimateOffset();
        $message->setOrderTokenValue('token_value');

        $climateOffsettingApplicator = $this->prophesize(ClimateOffsettingApplicatorInterface::class);
        $orderRepository = $this->prophesize(OrderRepositoryInterface::class);

        $this->expectException(UnrecoverableMessageHandlingException::class);

        $handler = new ApplyClimateOffsetHandler($climateOffsettingApplicator->reveal(), $orderRepository->reveal());
        $handler($message);
    }
}
