<?php

declare(strict_types=1);

use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Transactions\Operations\Revise\TransactionReviseAddress;
use Paddle\SDK\Resources\Transactions\Operations\Revise\TransactionReviseBusiness;
use Paddle\SDK\Resources\Transactions\Operations\Revise\TransactionReviseCustomer;
use Paddle\SDK\Resources\Transactions\Operations\ReviseTransaction;

require __DIR__ . '/../vendor/autoload.php';

$environment = Paddle\SDK\Environment::tryFrom(getenv('PADDLE_ENVIRONMENT') ?: '') ?? Paddle\SDK\Environment::SANDBOX;
$apiKey = getenv('PADDLE_API_KEY') ?: null;
$transactionId = getenv('PADDLE_TRANSACTION_ID') ?: null;

if (is_null($apiKey)) {
    echo "You must provide the PADDLE_API_KEY in the environment:\n";
    echo "PADDLE_API_KEY=your-key php examples/basic_usage.php\n";
    exit(1);
}

$paddle = new Paddle\SDK\Client($apiKey, options: new Paddle\SDK\Options($environment));

// ┌───
// │ Revise Transaction │
// └────────────────────┘
try {
    $transaction = $paddle->transactions->revise(
        $transactionId,
        new ReviseTransaction(
            address: new TransactionReviseAddress(
                firstLine: '123 Some Street',
                secondLine: null,
            ),
            business: new TransactionReviseBusiness(
                name: 'Some Business',
                taxIdentifier: '555952383',
            ),
            customer: new TransactionReviseCustomer(
                name: 'Some Name',
            ),
        ),
    );
} catch (ApiError|MalformedResponse $e) {
    var_dump($e);
    exit;
}

echo sprintf("Transaction ID: %s\n", $transaction->id);
echo sprintf(" - Revised At: %s\n", $transaction->revisedAt->format(DATE_RFC3339_EXTENDED));
