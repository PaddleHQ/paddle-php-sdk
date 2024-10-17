<?php

declare(strict_types=1);

use Paddle\SDK\Entities\Price;
use Paddle\SDK\Entities\Shared\CountryCode;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Entities\Shared\CustomData;
use Paddle\SDK\Entities\Shared\Interval;
use Paddle\SDK\Entities\Shared\Money;
use Paddle\SDK\Entities\Shared\PriceQuantity;
use Paddle\SDK\Entities\Shared\Status;
use Paddle\SDK\Entities\Shared\TaxCategory;
use Paddle\SDK\Entities\Shared\TimePeriod;
use Paddle\SDK\Entities\Shared\UnitPriceOverride;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\ApiError\PriceApiError;
use Paddle\SDK\Exceptions\ApiError\ProductApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Prices;
use Paddle\SDK\Resources\Prices\Operations\List\Includes as PriceIncludes;
use Paddle\SDK\Resources\Products;
use Paddle\SDK\Resources\Products\Operations\List\Includes as ProductIncludes;

require __DIR__ . '/../vendor/autoload.php';

$environment = Paddle\SDK\Environment::tryFrom(getenv('PADDLE_ENVIRONMENT') ?: '') ?? Paddle\SDK\Environment::SANDBOX;
$apiKey = getenv('PADDLE_API_KEY') ?: null;

if (is_null($apiKey)) {
    echo "You must provide the PADDLE_API_KEY in the environment:\n";
    echo "PADDLE_API_KEY=your-key php examples/basic_usage.php\n";
    exit(1);
}

$paddle = new Paddle\SDK\Client($apiKey, options: new Paddle\SDK\Options($environment));

// ┌───
// │ Create Product │
// └────────────────┘
try {
    $product = $paddle->products->create(new Products\Operations\CreateProduct(
        name: 'Kitten Service',
        taxCategory: TaxCategory::Standard(),
        description: 'Simply an awesome product',
        imageUrl: 'http://placekitten.com/200/300',
        customData: new CustomData(['foo' => 'bar']),
    ));
} catch (ProductApiError|ApiError|MalformedResponse $e) {
    var_dump($e);
    exit;
}

echo sprintf("Created product '%s': %s \n", $product->id, $product->description);

// ┌───
// │ Update Product │
// └────────────────┘
$update = new Products\Operations\UpdateProduct(
    name: 'Bear Service',
    imageUrl: 'https://placebear.com/200/300',
    customData: new CustomData(['beep' => 'boop']),
);

try {
    $product = $paddle->products->update($product->id, $update);
} catch (ProductApiError|ApiError|MalformedResponse $e) {
    var_dump($e);
    exit;
}

echo sprintf("Updated product '%s': %s \n", $product->id, $product->description);

// ┌───
// │ Create Price │
// └──────────────┘
try {
    $price = $paddle->prices->create(new Prices\Operations\CreatePrice(
        description: 'Bear Hug',
        productId: $product->id,
        unitPrice: new Money('1000', CurrencyCode::GBP()),
        unitPriceOverrides: [
            new UnitPriceOverride(
                [CountryCode::CA(), CountryCode::US()],
                new Money('5000', CurrencyCode::USD()),
            ),
        ],
        trialPeriod: new TimePeriod(Interval::Week(), 1),
        billingCycle: new TimePeriod(Interval::Year(), 1),
        quantity: new PriceQuantity(1, 1),
        customData: new CustomData(['foo' => 'bar']),
    ));
} catch (PriceApiError|ApiError|MalformedResponse $e) {
    var_dump($e);
    exit;
}

echo sprintf("Created price '%s': %s \n", $price->id, $price->description);

// ┌───
// │ Update Price │
// └──────────────┘
$update = new Prices\Operations\UpdatePrice(
    description: 'One-off Bear Hug',
    unitPrice: new Money('500', CurrencyCode::GBP()),
    customData: new CustomData(['beep' => 'boop']),
);

try {
    $test = json_encode($update, JSON_THROW_ON_ERROR);
} catch (JsonException $e) {
    $test = 1;
}

try {
    $price = $paddle->prices->update($price->id, $update);
} catch (PriceApiError|ApiError|MalformedResponse $e) {
    var_dump($e);
    exit;
}

echo sprintf("Updated price '%s': %s \n", $price->id, $price->description);

// ┌───
// │ Get Product with Prices │
// └─────────────────────────┘
try {
    $product = $paddle->products->get($product->id, [ProductIncludes::Prices()]);
} catch (ApiError|MalformedResponse $e) {
    var_dump($e);
    exit;
}

echo sprintf(
    "Read product '%s' with prices %s \n",
    $product->id,
    implode(', ', array_map(fn (Price $price) => $price->id, iterator_to_array($product->prices))),
);

// ┌───
// │ Get Price with Product │
// └────────────────────────┘
try {
    $price = $paddle->prices->get($price->id, [PriceIncludes::Product()]);
} catch (ApiError|MalformedResponse $e) {
    var_dump($e);
    exit;
}

echo sprintf("Read price '%s' with product %s \n", $price->id, $price->product?->id ?? '????');

// ┌───
// │ Get Products │
// └──────────────┘
try {
    $products = $paddle->products->list(new Products\Operations\ListProducts(
        includes: [ProductIncludes::Prices()],
        statuses: [Status::Active()],
    ));
} catch (ApiError|MalformedResponse $e) {
    var_dump($e);
    exit;
}

// ┌───
// │ Iterate Products and Prices │
// └─────────────────────────────┘
foreach ($products as $product) {
    echo $product->name;
    echo "\n";
    echo str_repeat('-', strlen($product->name)) . "\n";
    foreach ($product->prices ?? [] as $price) {
        echo sprintf("%s - %s\n", $price->unitPrice->amount, $price->description);
    }
    echo "\n";
}
