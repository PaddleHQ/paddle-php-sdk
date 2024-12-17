<?php

declare(strict_types=1);

use Paddle\SDK\Entities\Shared\Action;
use Paddle\SDK\Entities\Shared\AdjustmentType;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Adjustments\Operations\Create\AdjustmentItem;
use Paddle\SDK\Resources\Adjustments\Operations\CreateAdjustment;

require __DIR__ . '/../vendor/autoload.php';

$environment = Paddle\SDK\Environment::tryFrom(getenv('PADDLE_ENVIRONMENT') ?: '') ?? Paddle\SDK\Environment::SANDBOX;
$apiKey = getenv('PADDLE_API_KEY') ?: null;
$transactionId = getenv('PADDLE_TRANSACTION_ID') ?: null;
$transactionItemId = getenv('PADDLE_TRANSACTION_ITEM_ID') ?: null;
$fullAdjustmentTransactionId = getenv('PADDLE_FULL_ADJUSTMENT_TRANSACTION_ID') ?: null;

if (is_null($apiKey)) {
    echo "You must provide the PADDLE_API_KEY in the environment:\n";
    echo "PADDLE_API_KEY=your-key php examples/basic_usage.php\n";
    exit(1);
}

$paddle = new Paddle\SDK\Client($apiKey, options: new Paddle\SDK\Options($environment));

// ┌───
// │ Create Partial Adjustment │
// └───────────────────────────┘
try {
    $partialAdjustment = $paddle->adjustments->create(
        CreateAdjustment::partial(
            Action::Refund(),
            [
                new AdjustmentItem(
                    $transactionItemId,
                    AdjustmentType::Partial(),
                    '100',
                ),
            ],
            'error',
            $transactionId,
        ),
    );
} catch (ApiError|MalformedResponse $e) {
    var_dump($e);
    exit;
}

echo sprintf("Partial Adjustment ID: %s\n", $partialAdjustment->id);

// ┌───
// │ Create Full Adjustment │
// └────────────────────────┘
try {
    $fullAdjustment = $paddle->adjustments->create(
        CreateAdjustment::full(
            Action::Refund(),
            'error',
            $fullAdjustmentTransactionId,
        ),
    );
} catch (ApiError|MalformedResponse $e) {
    var_dump($e);
    exit;
}

echo sprintf("Full Adjustment ID: %s\n", $fullAdjustment->id);
