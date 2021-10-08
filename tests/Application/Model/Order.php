<?php
declare(strict_types=1);


namespace Tests\Setono\SyliusClimatePartnerPlugin\Application\Model;

use Doctrine\ORM\Mapping as ORM;
use Setono\SyliusClimatePartnerPlugin\Model\OrderInterface;
use Setono\SyliusClimatePartnerPlugin\Model\OrderTrait;
use Sylius\Component\Core\Model\Order as BaseOrder;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_order")
 */
class Order extends BaseOrder implements OrderInterface
{
    use OrderTrait;
}
