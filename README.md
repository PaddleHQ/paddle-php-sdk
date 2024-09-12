# Paddle PHP SDK

[![Build Status](https://github.com/PaddleHQ/paddle-php-sdk/actions/workflows/ci.yml/badge.svg?branch=main)](https://github.com/PaddleHQ/paddle-php-sdk/actions/?query=branch%3Amain)
[![Latest Stable Version](https://poser.pugx.org/paddlehq/paddle-php-sdk/v)](https://packagist.org/packages/paddlehq/paddle-php-sdk)
[![Total Downloads](https://poser.pugx.org/paddlehq/paddle-php-sdk/downloads)](https://packagist.org/packages/paddlehq/paddle-php-sdk)
[![License](https://poser.pugx.org/paddlehq/paddle-php-sdk/license)](https://packagist.org/packages/paddlehq/paddle-php-sdk)

[Paddle Billing](https://www.paddle.com/billing?utm_source=dx&utm_medium=paddle-php-sdk) is a complete digital product sales and subscription management platform, designed for modern software businesses. It helps you increase your revenue, retain customers, and scale your operations.

This is a [PHP](https://www.php.net/) SDK that you can use to integrate Paddle Billing with applications written in PHP.

For working with Paddle in your frontend, use [Paddle.js](https://developer.paddle.com/paddlejs/overview?utm_source=dx&utm_medium=paddle-php-sdk). You can open checkouts, securely collect payment information, build pricing pages, and integrate with Paddle Retain.

> **Important:** This package works with Paddle Billing. It does not support Paddle Classic. To work with Paddle Classic, see: [Paddle Classic API reference](https://developer.paddle.com/classic/api-reference/1384a288aca7a-api-reference?utm_source=dx&utm_medium=paddle-php-sdk)

## Requirements

PHP 8.1 and later.

## Composer

You can install the bindings via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require paddlehq/paddle-php-sdk
```

To use the bindings, use Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once 'vendor/autoload.php';
```

## Usage

To authenticate, you'll need an API key. You can create and manage API keys in **Paddle > Developer tools > Authentication**.

Pass your API key while initializing a new Paddle client.

``` php
use Paddle\SDK\Client;

$paddle = new Client('API_KEY');
```

You can also pass an environment to work with the sandbox:

``` php
use Paddle\SDK\Client;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;

$paddle = new Client(
    apiKey: 'API_KEY',
    options: new Options(Environment::SANDBOX),
);
```

Keep in mind that API keys are separate for your sandbox and live accounts, so you'll need to generate keys for each environment.

## Examples

### List entities

You can list supported entities with the `list` function in the resource. It returns an iterator to help when working with multiple pages.

``` php
use Paddle\SDK\Client;

$paddle = new Client('API_KEY');

$products = $paddle->products->list();

// List returns an iterable, so pagination is handled automatically.
foreach ($products as $product) {
    echo $product->id;
}
```

### Create an entity

You can create a supported entity with the `create` function in the resource. It accepts the resource's corresponding `Create` operation e.g. `CreateProduct`. The created entity is returned.

``` php
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Shared\TaxCategory;
use Paddle\SDK\Resources\Products\Operations\CreateProduct;

$paddle = new Client('API_KEY');

$product = $paddle->products->create(
    new CreateProduct(
        name: 'ChatApp Education',
        taxCategory: TaxCategory::Standard(),
    ),
);
```

### Update an entity

You can update a supported entity with the `update` function in the resource. It accepts the `id` of the entity to update and the corresponding `Update` operation e.g. `UpdateProduct`. The updated entity is returned.

``` php
use Paddle\SDK\Client;
use Paddle\SDK\Resources\Products\Operations\UpdateProduct;

$paddle = new Client('API_KEY');

$operation = new UpdateProduct(
    name: 'ChatApp Professional'
);

$product = $paddle->products->update('id', $operation);
```

Where operations require more than one `id`, the `update` function accepts multiple arguments. For example, to update an address for a customer, pass the `customerId` and the `addressId`:

``` php
$address = $paddle->addresses->update(
    'customer_id',
    'address_id',
    $operation,
);
```

### Get an entity

You can get an entity with the `get` function in the resource. It accepts the `id` of the entity to get. The entity is returned.

``` php
use Paddle\SDK\Client;

$paddle = new Client('API_KEY');

$product = $paddle->products->get('id');
```

## Resources

### Webhook signature verification

The SDK includes a helper class to verify webhook signatures sent by Notifications from Paddle.

``` php
use Paddle\SDK\Notifications\Secret;
use Paddle\SDK\Notifications\Verifier;

(new Verifier())->verify(
    $request,
    new Secret('WEBHOOK_SECRET_KEY')
);
```

## Learn more

- [Paddle API reference](https://developer.paddle.com/api-reference/overview?utm_source=dx&utm_medium=paddle-php-sdk)
- [Sign up for Paddle Billing](https://login.paddle.com/signup?utm_source=dx&utm_medium=paddle-php-sdk)
