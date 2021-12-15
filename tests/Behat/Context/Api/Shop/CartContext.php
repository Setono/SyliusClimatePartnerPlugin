<?php

declare(strict_types=1);

namespace Tests\Setono\SyliusClimatePartnerPlugin\Behat\Context\Api\Shop;

use Behat\Behat\Context\Context;
use Sylius\Behat\Client\ApiClientInterface;
use Sylius\Behat\Client\Request;
use Sylius\Behat\Client\ResponseCheckerInterface;
use Sylius\Behat\Service\SharedStorageInterface;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

final class CartContext implements Context
{
    private ApiClientInterface $cartsClient;

    private ResponseCheckerInterface $responseChecker;

    private SharedStorageInterface $sharedStorage;

    public function __construct(
        ApiClientInterface $cartsClient,
        ResponseCheckerInterface $responseChecker,
        SharedStorageInterface $sharedStorage
    ) {
        $this->cartsClient = $cartsClient;
        $this->responseChecker = $responseChecker;
        $this->sharedStorage = $sharedStorage;
    }

    /**
     * @When I apply climate offset
     */
    public function iApplyClimateOffset(): void
    {
        $tokenValue = $this->pickupCart();

        $request = Request::customItemAction(
            'shop',
            'orders',
            $tokenValue,
            HttpRequest::METHOD_PATCH,
            'apply-climate-offset'
        );

        $this->cartsClient->executeCustomRequest($request);
    }

    /**
     * @When I remove climate offset
     */
    public function iRemoveClimateOffset(): void
    {
        $tokenValue = $this->pickupCart();

        $request = Request::customItemAction(
            'shop',
            'orders',
            $tokenValue,
            HttpRequest::METHOD_PATCH,
            'remove-climate-offset'
        );

        $this->cartsClient->executeCustomRequest($request);
    }

    private function pickupCart(): string
    {
        $this->cartsClient->buildCreateRequest();
        /** @psalm-suppress NullArgument */
        $this->cartsClient->addRequestData('localeCode', null);

        /** @psalm-var string $tokenValue */
        $tokenValue = $this->responseChecker->getValue($this->cartsClient->create(), 'tokenValue');

        $this->sharedStorage->set('cart_token', $tokenValue);

        return $tokenValue;
    }
}
