<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Unit\Exception;

use PHPUnit\Framework\TestCase;
use Setono\SyliusClimatePartnerPlugin\Exception\OrderIsNotExpectedTypeException;
use Sylius\Component\Core\Model\Order;

/**
 * @covers \Setono\SyliusClimatePartnerPlugin\Exception\OrderIsNotExpectedTypeException
 */
final class OrderIsNotExpectedTypeExceptionTest extends TestCase
{
    /**
     * @test
     */
    public function it_asserts(): void
    {
        $this->expectException(OrderIsNotExpectedTypeException::class);

        OrderIsNotExpectedTypeException::assert(new Order());
    }
}
