<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Repository;

use Setono\SyliusClimatePartnerPlugin\Model\ChannelClimateFeeInterface;
use Sylius\Component\Channel\Model\ChannelInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

interface ChannelClimateFeeRepositoryInterface extends RepositoryInterface
{
    public function findOneByChannel(ChannelInterface $channel): ?ChannelClimateFeeInterface;
}
