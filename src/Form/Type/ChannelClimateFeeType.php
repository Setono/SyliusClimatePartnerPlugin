<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Form\Type;

use Setono\SyliusClimatePartnerPlugin\Model\ChannelClimateFeeInterface;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Bundle\MoneyBundle\Form\Type\MoneyType;
use Sylius\Bundle\ResourceBundle\Form\Type\AbstractResourceType;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\ChannelInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Webmozart\Assert\Assert;

final class ChannelClimateFeeType extends AbstractResourceType
{
    private ChannelRepositoryInterface $channelRepository;

    /**
     * @param array<array-key, string> $validationGroups
     */
    public function __construct(ChannelRepositoryInterface $channelRepository, string $dataClass, array $validationGroups = [])
    {
        parent::__construct($dataClass, $validationGroups);

        $this->channelRepository = $channelRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('channel', ChannelChoiceType::class, [
                'label' => 'setono_sylius_climate_partner.form.channel_climate_fee.channel',
                'placeholder' => 'setono_sylius_climate_partner.form.channel_climate_fee.channel_placeholder',
            ])->addEventListener(FormEvents::PRE_SET_DATA, static function (FormEvent $event): void {
                /** @var ChannelClimateFeeInterface|mixed $data */
                $data = $event->getData();
                Assert::isInstanceOf($data, ChannelClimateFeeInterface::class);

                $formOptions = [
                    'label' => 'setono_sylius_climate_partner.form.channel_climate_fee.fee',
                ];
                if ($data->getId() !== null) {
                    /** @var ChannelInterface|null $channel */
                    $channel = $data->getChannel();
                    Assert::isInstanceOf($channel, ChannelInterface::class);

                    $baseCurrency = $channel->getBaseCurrency();
                    Assert::notNull($baseCurrency);

                    $formOptions['currency'] = (string) $baseCurrency->getCode();
                }

                $event->getForm()->add('fee', MoneyType::class, $formOptions);
            })
        ;

        /**
         * NOTICE: The only reason we make these prototypes is that the MoneyType renders a currency symbol,
         * and we want to render the correct symbol which makes for a good user experience :)
         */
        $feePrototypes = [];

        /** @var ChannelInterface $channel */
        foreach ($this->channelRepository->findAll() as $channel) {
            $baseCurrency = $channel->getBaseCurrency();
            Assert::notNull($baseCurrency);

            $feePrototypes[(string) $channel->getCode()] = $builder->create('fee', MoneyType::class, [
                'currency' => (string) $baseCurrency->getCode(),
            ])->getForm();
        }

        $builder->setAttribute('fee_prototypes', $feePrototypes);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['fee_prototypes'] = [];

        /** @var array<string, FormInterface> $feePrototypes */
        $feePrototypes = $form->getConfig()->getAttribute('fee_prototypes');
        foreach ($feePrototypes as $channelCode => $feePrototype) {
            $view->vars['fee_prototypes'][$channelCode] = $feePrototype->setParent($form)->createView($view);
        }
    }

    public function getBlockPrefix(): string
    {
        return 'setono_sylius_climate_partner_channel_climate_fee';
    }
}
