<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Form\Type;

use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\MoneyBundle\Form\Type\MoneyType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Symfony\Component\Form\FormBuilderInterface;

final class ChannelClimateFeeType extends AbstractResourceType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fee', MoneyType::class, [
                'label' => 'sylius.ui.price',
            ])
            ->add('channel', ChannelChoiceType::class, [
                'label' => 'setono_sylius_climate_partner.form.channel_climate_fee.channel',
            ])
        ;
    }
}
