<?php

declare(strict_types=1);

use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\CustomerPortalSessions\Operations\CreateCustomerPortalSession;

require __DIR__ . '/../vendor/autoload.php';

$environment = Paddle\SDK\Environment::tryFrom(getenv('PADDLE_ENVIRONMENT') ?: '') ?? Paddle\SDK\Environment::SANDBOX;
$apiKey = getenv('PADDLE_API_KEY') ?: null;
$customerId = getenv('PADDLE_CUSTOMER_ID') ?: null;
$subscriptionId = getenv('PADDLE_SUBSCRIPTION_ID') ?: null;

if (is_null($apiKey)) {
    echo "You must provide the PADDLE_API_KEY in the environment:\n";
    echo "PADDLE_API_KEY=your-key php examples/basic_usage.php\n";
    exit(1);
}

$paddle = new Paddle\SDK\Client($apiKey, options: new Paddle\SDK\Options($environment));

// ┌───
// │ Create Customer Portal Session │
// └────────────────────────────────┘
try {
    $customerPortalSession = $paddle->customerPortalSessions->create(
        $customerId,
        new CreateCustomerPortalSession([$subscriptionId]),
    );
} catch (ApiError|MalformedResponse $e) {
    var_dump($e);
    exit;
}

echo sprintf("Created Customer Portal Session: %s\n", $customerPortalSession->id);
echo sprintf("  - Customer ID: %s\n", $customerPortalSession->customerId);
echo sprintf("  - Created At: %s\n", $customerPortalSession->createdAt->format(DATE_RFC3339_EXTENDED));
echo sprintf("  - General Overview URL: %s\n", $customerPortalSession->urls->general->overview);

foreach ($customerPortalSession->urls->subscriptions as $subscriptionUrl) {
    echo sprintf("  - Subscription URLs: %s\n", $subscriptionUrl->id);
    echo sprintf("      - Update Subscription Payment Method URL: %s\n", $subscriptionUrl->updateSubscriptionPaymentMethod);
    echo sprintf("      - Cancel URL: %s\n", $subscriptionUrl->cancelSubscription);
}
