<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Repository;

use Setono\SyliusClimatePartnerPlugin\Model\ChannelClimateFeeInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Channel\Model\ChannelInterface;
use Webmozart\Assert\Assert;

class ChannelClimateFeeRepository extends EntityRepository implements ChannelClimateFeeRepositoryInterface
{
    public function findOneByChannel(ChannelInterface $channel): ?ChannelClimateFeeInterface
    {
        $obj = $this->findOneBy([
            'channel' => $channel,
        ]);

        Assert::nullOrIsInstanceOf($obj, ChannelClimateFeeInterface::class);

        return $obj;
    }
}
