# Sylius Climate Partner Plugin

[![Latest Version][ico-version]][link-packagist]
[![Latest Unstable Version][ico-unstable-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![Build Status][ico-github-actions]][link-github-actions]
[![Code Coverage][ico-code-coverage]][link-code-coverage]

This plugin will allow customers to add climate offsets to their orders.

https://user-images.githubusercontent.com/2412177/146182689-d0d5e44f-f159-45e9-aecf-0578105546b3.mp4

## Installation

```bash
composer require setono/sylius-climate-partner-plugin
```

### Import configuration

```yaml
# config/packages/setono_sylius_climate_partner.yaml
imports:
    # ...
    - { resource: "@SetonoSyliusClimatePartnerPlugin/Resources/config/app/config.yaml" }
```

### Import routing

```yaml
# config/routes/setono_sylius_climate_partner.yaml
setono_sylius_climate_partner:
    resource: "@SetonoSyliusClimatePartnerPlugin/Resources/config/routes.yaml"
```

or if your app doesn't use locales:

```yaml
# config/routes/setono_sylius_climate_partner.yaml
setono_sylius_climate_partner:
    resource: "@SetonoSyliusClimatePartnerPlugin/Resources/config/routes_no_locale.yaml"
```

### Add plugin class to your `bundles.php`

Make sure you add it before `SyliusGridBundle`, otherwise you'll get
`You have requested a non-existent parameter "setono_sylius_climate_partner.model.channel_climate_fee.class".` exception.

```php
<?php
// config/bundles.php

$bundles = [
    // ...
    Setono\SyliusClimatePartnerPlugin\SetonoSyliusClimatePartnerPlugin::class => ['all' => true],
    Sylius\Bundle\GridBundle\SyliusGridBundle::class => ['all' => true],
    // ...
];
```

### Copy API resources

In order to add ClimatePartner API endpoints to Sylius Order section, the API Resource declaration has to be overridden.
If you've not overridden those configuration yet, you can simply copy the whole files into your local `config/api_resources` folder.
If you've overridden them already, then you can just merge your config with the endpoints we added.

Resources declaration that need to be copied are:
* [Order.xml](src/Resources/config/api_resources/Order.xml)

If you already have them overridden, just add the following item operations:

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

[ico-version]: https://poser.pugx.org/setono/sylius-climate-partner-plugin/v/stable
[ico-unstable-version]: https://poser.pugx.org/setono/sylius-climate-partner-plugin/v/unstable
[ico-license]: https://poser.pugx.org/setono/sylius-climate-partner-plugin/license
[ico-github-actions]: https://github.com/Setono/SyliusClimatePartnerPlugin/workflows/build/badge.svg
[ico-code-coverage]: https://codecov.io/gh/Setono/SyliusClimatePartnerPlugin/branch/master/graph/badge.svg

[link-packagist]: https://packagist.org/packages/setono/sylius-climate-partner-plugin
[link-github-actions]: https://github.com/Setono/SyliusClimatePartnerPlugin/actions
[link-code-coverage]: https://codecov.io/gh/Setono/SyliusClimatePartnerPlugin
