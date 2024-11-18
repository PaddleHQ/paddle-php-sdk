<?php

declare(strict_types=1);

use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;

require __DIR__ . '/../vendor/autoload.php';

$environment = Paddle\SDK\Environment::tryFrom(getenv('PADDLE_ENVIRONMENT') ?: '') ?? Paddle\SDK\Environment::SANDBOX;
$apiKey = getenv('PADDLE_API_KEY') ?: null;
$customerId = getenv('PADDLE_CUSTOMER_ID') ?: null;

if (is_null($apiKey)) {
    echo "You must provide the PADDLE_API_KEY in the environment:\n";
    echo "PADDLE_API_KEY=your-key php examples/basic_usage.php\n";
    exit(1);
}

$paddle = new Paddle\SDK\Client($apiKey, options: new Paddle\SDK\Options($environment));

// ┌───
// │ Create Customer Auth Token │
// └────────────────────────────┘
try {
    $authToken = $paddle->customers->generateAuthToken($customerId);
} catch (ApiError|MalformedResponse $e) {
    var_dump($e);
    exit;
}

echo sprintf("Created Customer Auth Token: %s\n", $authToken->customerAuthToken);
echo sprintf("  - Expires At: %s\n", $authToken->expiresAt->format(DATE_RFC3339_EXTENDED));
