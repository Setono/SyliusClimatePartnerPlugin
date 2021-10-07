<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\DependencyInjection;

use Matthias\SymfonyConfigTest\PhpUnit\ConfigurationTestCaseTrait;
use PHPUnit\Framework\TestCase;
use Setono\SyliusClimatePartnerPlugin\DependencyInjection\Configuration;
use Setono\SyliusClimatePartnerPlugin\Form\Type\ChannelClimateFeeType;
use Setono\SyliusClimatePartnerPlugin\Model\ChannelClimateFee;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\Component\Resource\Factory\Factory;

/**
 * See examples of tests and configuration options here: https://github.com/SymfonyTest/SymfonyConfigTest
 */
final class ConfigurationTest extends TestCase
{
    use ConfigurationTestCaseTrait;

    protected function getConfiguration(): Configuration
    {
        return new Configuration();
    }

    /**
     * @test
     */
    public function processed_value_contains_required_value(): void
    {
        $this->assertProcessedConfigurationEquals([], [
            'driver' => SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
            'resources' => [
                'channel_climate_fee' => [
                    'classes' => [
                        'controller' => ResourceController::class,
                        'factory' => Factory::class,
                        'form' => ChannelClimateFeeType::class,
                        'model' => ChannelClimateFee::class,
                    ],
                ],
            ],
        ]);
    }
}
