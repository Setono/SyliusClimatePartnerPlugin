<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Menu;

use Knp\Menu\MenuFactory;
use PHPUnit\Framework\TestCase;
use Setono\SyliusClimatePartnerPlugin\Menu\AdminMenuBuilder;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

/**
 * @covers \Setono\SyliusClimatePartnerPlugin\Menu\AdminMenuBuilder
 */
final class AdminMenuBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function it_adds_item(): void
    {
        $factory = new MenuFactory();
        $menu = $factory->createItem('root');
        $event = new MenuBuilderEvent($factory, $menu);

        $builder = new AdminMenuBuilder();
        $builder->addSection($event);

        self::assertCount(1, $menu->getChildren());
    }
}
