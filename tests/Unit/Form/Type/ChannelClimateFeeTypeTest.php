<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Unit\Form\Type;

use Prophecy\PhpUnit\ProphecyTrait;
use Setono\SyliusClimatePartnerPlugin\Form\Type\ChannelClimateFeeType;
use Setono\SyliusClimatePartnerPlugin\Model\ChannelClimateFee;
use Sylius\Bundle\ChannelBundle\Form\Type\ChannelChoiceType;
use Sylius\Component\Channel\Repository\ChannelRepositoryInterface;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Currency\Model\Currency;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @covers \Setono\SyliusClimatePartnerPlugin\Form\Type\ChannelClimateFeeType
 */
final class ChannelClimateFeeTypeTest extends TypeTestCase
{
    use ProphecyTrait;

    private ?Channel $channel = null;

    /**
     * @test
     */
    public function it_submits_data(): void
    {
        $formData = [
            'fee' => 1,
            'channel' => 'FASHION_WEB',
        ];

        $model = new ChannelClimateFee();
        // $formData will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(ChannelClimateFeeType::class, $model);

        $expected = new ChannelClimateFee();
        $expected->setFee(100);
        $expected->setChannel($this->getChannel());
        // ...populate $object properties with the data stored in $formData

        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $formData was modified as expected when the form was submitted
        $this->assertEquals($expected, $model);
    }

    /**
     * @test
     */
    public function it_adds_fee_prototypes(): void
    {
        $formData = new ChannelClimateFee();
        // ... prepare the data as you need

        // The initial data may be used to compute custom view variables
        $view = $this->factory->create(ChannelClimateFeeType::class, $formData)
            ->createView();

        self::assertArrayHasKey('fee_prototypes', $view->vars);
        self::assertIsArray($view->vars['fee_prototypes']);
        self::assertCount(1, $view->vars['fee_prototypes']);

        foreach ($view->vars['fee_prototypes'] as $key => $value) {
            self::assertIsString($key);
            self::assertInstanceOf(FormView::class, $value);
        }
    }

    protected function getExtensions(): array
    {
        $repository = $this->prophesize(ChannelRepositoryInterface::class);
        $repository->findAll()->willReturn([$this->getChannel()]);

        // create a type instance with the mocked dependencies
        $channelClimateFeeType = new ChannelClimateFeeType($repository->reveal(), ChannelClimateFee::class);

        $channelChoiceType = new ChannelChoiceType($repository->reveal());

        return [
            // register the type instances with the PreloadedExtension
            new PreloadedExtension([$channelClimateFeeType, $channelChoiceType], []),
        ];
    }

    private function getChannel(): Channel
    {
        if (null === $this->channel) {
            $baseCurrency = new Currency();
            $baseCurrency->setCode('USD');
            $channel = new Channel();
            $channel->setBaseCurrency($baseCurrency);
            $channel->setCode('FASHION_WEB');

            $this->channel = $channel;
        }

        return $this->channel;
    }
}
