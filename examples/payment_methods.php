<?php

declare(strict_types=1);

use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\PaymentMethods\Operations\ListPaymentMethods;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

require __DIR__ . '/../vendor/autoload.php';

$environment = Paddle\SDK\Environment::tryFrom(getenv('PADDLE_ENVIRONMENT') ?: '') ?? Paddle\SDK\Environment::SANDBOX;
$apiKey = getenv('PADDLE_API_KEY') ?: null;
$customerId = getenv('PADDLE_CUSTOMER_ID') ?: null;
$paymentMethodId = getenv('PADDLE_PAYMENT_METHOD_ID') ?: null;

if (is_null($apiKey)) {
    echo "You must provide the PADDLE_API_KEY in the environment:\n";
    echo "PADDLE_API_KEY=your-key php examples/basic_usage.php\n";
    exit(1);
}

$paddle = new Paddle\SDK\Client($apiKey, options: new Paddle\SDK\Options($environment));

// ┌───
// │ List Payment Methods │
// └──────────────────────┘
try {
    $paymentMethods = $paddle->paymentMethods->list(
        $customerId,
        new ListPaymentMethods(
            pager: new Pager(perPage: 10),
        ),
    );
} catch (ApiError|MalformedResponse $e) {
    var_dump($e);
    exit;
}

echo "List Payment Methods\n";

foreach ($paymentMethods as $paymentMethod) {
    echo sprintf("- %s:\n", $paymentMethod->id);
    echo sprintf("  - Type: %s\n", $paymentMethod->type->getValue());

    if ($paymentMethod->card) {
        echo sprintf("  - Card Type: %s\n", $paymentMethod->card->type->getValue());
        echo sprintf("  - Card Holder Name: %s\n", $paymentMethod->card->cardholderName);
        echo sprintf("  - Card Last 4 Digits: %s\n", $paymentMethod->card->last4);
        echo sprintf("  - Card Expiry Year: %d\n", $paymentMethod->card->expiryYear);
        echo sprintf("  - Card Expiry Month: %d\n", $paymentMethod->card->expiryMonth);
    }

    if ($paymentMethod->paypal) {
        echo sprintf("  - PayPal Reference: %s\n", $paymentMethod->paypal->reference);
        echo sprintf("  - PayPal Email: %s\n", $paymentMethod->paypal->email);
    }
}

// ┌───
// │ Get Payment Method |
// └────────────────────┘
try {
    $paymentMethod = $paddle->paymentMethods->get($customerId, $paymentMethodId);
} catch (ApiError|MalformedResponse $e) {
    var_dump($e);
    exit;
}

echo sprintf("Get Payment Method: %s\n", $paymentMethod->id);
echo sprintf("  - Type: %s\n", $paymentMethod->type->getValue());

if ($paymentMethod->card) {
    echo sprintf("  - Card Type: %s\n", $paymentMethod->card->type->getValue());
    echo sprintf("  - Card Holder Name: %s\n", $paymentMethod->card->cardholderName);
    echo sprintf("  - Card Last 4 Digits: %s\n", $paymentMethod->card->last4);
    echo sprintf("  - Card Expiry Year: %d\n", $paymentMethod->card->expiryYear);
    echo sprintf("  - Card Expiry Month: %d\n", $paymentMethod->card->expiryMonth);
}

if ($paymentMethod->paypal) {
    echo sprintf("  - PayPal Reference: %s\n", $paymentMethod->paypal->reference);
    echo sprintf("  - PayPal Email: %s\n", $paymentMethod->paypal->email);
}

// ┌───
// │ Delete Payment Method |
// └───────────────────────┘
try {
    $paddle->paymentMethods->delete($customerId, $paymentMethodId);
} catch (ApiError|MalformedResponse $e) {
    var_dump($e);
    exit;
}

echo sprintf("Deleted Payment Method: %s\n", $paymentMethodId);
echo sprintf("  - Type: %s\n", $paymentMethod->type->getValue());
