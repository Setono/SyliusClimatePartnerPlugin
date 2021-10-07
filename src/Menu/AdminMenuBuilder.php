<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Menu;

use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuBuilder
{
    public function addSection(MenuBuilderEvent $event): void
    {
        $header = $this->getHeader($event->getMenu());

        $header
            ->addChild('climate_partner', [
                'route' => 'setono_sylius_climate_partner_admin_channel_climate_fee_index',
            ])
            ->setLabel('setono_sylius_climate_partner.menu.admin.main.catalog.climate_partner')
            ->setLabelAttribute('icon', 'list alternate outline')
        ;
    }

    private function getHeader(ItemInterface $menu): ItemInterface
    {
        $header = $menu->getChild('catalog');
        if (null !== $header) {
            return $header;
        }

        return $menu;
    }
}
