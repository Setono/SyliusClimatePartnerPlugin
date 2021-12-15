<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Unit\Api\Command;

use PHPUnit\Framework\TestCase;
use Setono\SyliusClimatePartnerPlugin\Api\Command\ApplyClimateOffset;

final class ApplyClimateOffsetTest extends TestCase
{
    /**
     * @test
     */
    public function it_is_initializable(): void
    {
        $command = new ApplyClimateOffset();
        $this->assertInstanceOf(ApplyClimateOffset::class, $command);
    }

    /**
     * @test
     */
    public function it_has_properties(): void
    {
        $command = new ApplyClimateOffset();

        $this->assertNull($command->getOrderTokenValue());
        $command->setOrderTokenValue('token_value');
        $this->assertEquals('token_value', $command->getOrderTokenValue());
    }
}
