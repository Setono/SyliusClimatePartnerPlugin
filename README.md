# Sylius Climate Partner Plugin

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Code Coverage][ico-code-coverage]][link-code-coverage]

This plugin will allow customers to add climate offsets to their orders.

https://user-images.githubusercontent.com/2412177/146182689-d0d5e44f-f159-45e9-aecf-0578105546b3.mp4

## Installation

TODO

### Copy Api Resources

Resources declaration that need to be copied are:
* [Order.xml](src/Resources/config/api_resources/Order.xml)

If you already have them overridden, just change the following routes:

**[Order.xml](src/Resources/config/api_resources/Order.xml)**
```xml
<itemOperation name="shop_apply_climate_offset">
    <attribute name="method">PATCH</attribute>
    <attribute name="path">/shop/orders/{tokenValue}/apply-climate-offset</attribute>
    <attribute name="messenger">input</attribute>
    <attribute name="input">Setono\SyliusClimatePartnerPlugin\Api\Command\ApplyClimateOffset</attribute>
    <attribute name="openapi_context">
        <attribute name="summary">Apply climate offset to cart</attribute>
    </attribute>
    <attribute name="denormalization_context">
        <attribute name="groups">shop:climate-offset:apply</attribute>
    </attribute>
</itemOperation>

<itemOperation name="shop_remove_climate_offset">
    <attribute name="method">PATCH</attribute>
    <attribute name="path">/shop/orders/{tokenValue}/remove-climate-offset</attribute>
    <attribute name="messenger">input</attribute>
    <attribute name="input">Setono\SyliusClimatePartnerPlugin\Api\Command\RemoveClimateOffset</attribute>
    <attribute name="openapi_context">
        <attribute name="summary">Remove climate offset to cart</attribute>
    </attribute>
    <attribute name="denormalization_context">
        <attribute name="groups">shop:climate-offset:apply</attribute>
    </attribute>
</itemOperation>
```

## Usage

TODO

[ico-version]: https://poser.pugx.org/setono/sylius-climate-partner-plugin/v/stable
[ico-unstable-version]: https://poser.pugx.org/setono/sylius-climate-partner-plugin/v/unstable
[ico-license]: https://poser.pugx.org/setono/sylius-climate-partner-plugin/license
[ico-github-actions]: https://github.com/Setono/SyliusClimatePartnerPlugin/workflows/build/badge.svg
[ico-code-coverage]: https://codecov.io/gh/Setono/SyliusClimatePartnerPlugin/branch/master/graph/badge.svg

[link-packagist]: https://packagist.org/packages/setono/sylius-climate-partner-plugin
[link-github-actions]: https://github.com/Setono/SyliusClimatePartnerPlugin/actions
[link-code-coverage]: https://codecov.io/gh/Setono/SyliusClimatePartnerPlugin
