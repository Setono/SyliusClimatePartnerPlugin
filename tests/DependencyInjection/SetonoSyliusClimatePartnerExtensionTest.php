<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\SyliusClimatePartnerPlugin\DependencyInjection\SetonoSyliusClimatePartnerExtension;

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
}
