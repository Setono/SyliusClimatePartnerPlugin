<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Model;

use Sylius\Component\Channel\Model\ChannelAwareInterface;
use Sylius\Component\Resource\Model\ResourceInterface;

interface ChannelClimateFeeInterface extends ResourceInterface, ChannelAwareInterface
{
    public function getId(): ?int;

    public function getFee(): ?int;

    public function setFee(?int $fee): void;
}
