<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Model;

use Sylius\Component\Channel\Model\ChannelInterface;

class ChannelClimateFee implements ChannelClimateFeeInterface
{
    protected ?int $id = null;

    protected ?int $fee = null;

    protected ?ChannelInterface $channel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFee(): ?int
    {
        return $this->fee;
    }

    public function setFee(int $fee): void
    {
        $this->fee = $fee;
    }

    public function getChannel(): ?ChannelInterface
    {
        return $this->channel;
    }

    public function setChannel(?ChannelInterface $channel): void
    {
        $this->channel = $channel;
    }
}
