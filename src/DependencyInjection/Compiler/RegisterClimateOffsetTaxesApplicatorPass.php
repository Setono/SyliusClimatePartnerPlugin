<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Webmozart\Assert\Assert;

final class RegisterClimateOffsetTaxesApplicatorPass implements CompilerPassInterface
{
    private const APPLICATOR_ID = 'setono_sylius_climate_partner.taxation.applicator.climate_offset_taxes';

    public function process(ContainerBuilder $container): void
    {
        if (!$container->has(self::APPLICATOR_ID)) {
            return;
        }

        $taxationStrategyIds = [
            'sylius.taxation.order_items_based_strategy',
            'sylius.taxation.order_item_units_based_strategy',
        ];

        foreach ($taxationStrategyIds as $id) {
            if (!$container->has($id)) {
                return;
            }
        }

        foreach ($taxationStrategyIds as $id) {
            $this->registerTaxesApplicator($container, $id);
        }
    }

    private function registerTaxesApplicator(ContainerBuilder $container, string $strategyId): void
    {
        $strategy = $container->getDefinition($strategyId);
        $applicators = $strategy->getArgument(1);
        Assert::isArray($applicators);

        $applicators[] = new Reference(self::APPLICATOR_ID);

        $strategy->setArgument(1, $applicators);
    }
}
