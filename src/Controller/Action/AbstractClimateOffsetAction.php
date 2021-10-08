<?php

declare(strict_types=1);

namespace Setono\SyliusClimatePartnerPlugin\Controller\Action;

use Setono\SyliusClimatePartnerPlugin\Applicator\ClimateOffsettingApplicatorInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

abstract class AbstractClimateOffsetAction
{
    private UrlGeneratorInterface $urlGenerator;

    private ClimateOffsettingApplicatorInterface $climateOffsettingApplicator;

    public function __construct(UrlGeneratorInterface $urlGenerator, ClimateOffsettingApplicatorInterface $climateOffsettingApplicator)
    {
        $this->urlGenerator = $urlGenerator;
        $this->climateOffsettingApplicator = $climateOffsettingApplicator;
    }

    public function __invoke(Request $request): Response
    {
        $url = $this->urlGenerator->generate('sylius_shop_cart_summary');

        if ($request->headers->has('referer')) {
            $referrer = $request->headers->get('referer');
            if (is_string($referrer) && '' !== $referrer) {
                $url = $referrer;
            }
        }

        $this->climateOffsettingApplicator->applyClimateOffsetting($this->getValue());

        return new RedirectResponse($url);
    }

    /**
     * Must return the climate offsetting value
     */
    abstract protected function getValue(): bool;
}
