<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Unit\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\SyliusClimatePartnerPlugin\DependencyInjection\SetonoSyliusClimatePartnerExtension;
use Setono\SyliusClimatePartnerPlugin\Form\Type\ChannelClimateFeeType;
use Setono\SyliusClimatePartnerPlugin\Model\ChannelClimateFee;
use Setono\SyliusClimatePartnerPlugin\Repository\ChannelClimateFeeRepository;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Sylius\Bundle\ResourceBundle\SyliusResourceBundle;
use Sylius\Component\Resource\Factory\Factory;

/**
 * See examples of tests and configuration options here: https://github.com/SymfonyTest/SymfonyDependencyInjectionTest
 */
final class SetonoSyliusClimatePartnerExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new SetonoSyliusClimatePartnerExtension(),
        ];
    }

    /**
     * @test
     */
    public function it_registers_resources(): void
    {
        $this->load();

        $this->assertContainerBuilderHasParameter('sylius.resources', [
            'setono_sylius_climate_partner.channel_climate_fee' => [
                'driver' => SyliusResourceBundle::DRIVER_DOCTRINE_ORM,
                'classes' => [
                    'controller' => ResourceController::class,
                    'factory' => Factory::class,
                    'form' => ChannelClimateFeeType::class,
                    'model' => ChannelClimateFee::class,
                    'repository' => ChannelClimateFeeRepository::class,
                ],
            ],
        ]);
    }
}
