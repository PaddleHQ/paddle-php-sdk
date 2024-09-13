<?php

declare(strict_types=1);

require 'vendor/autoload.php';

/*
 * Verify a webhook request using PSR-7 when using a framework that does not support PSR-7.
 * Only requirement is to install guzzlehttp/psr7 package `composer require guzzlehttp/psr7`
 * @see https://developer.paddle.com/webhooks/signature-verification#verify-sdks?utm_source=dx&utm_medium=paddle-php-sdk
 */

use GuzzleHttp\Psr7\ServerRequest;
use Paddle\SDK\Notifications\Events\TransactionUpdated;
use Paddle\SDK\Notifications\Notification;
use Paddle\SDK\Notifications\Secret;
use Paddle\SDK\Notifications\Verifier;

// Create a PSR-7 compliant request object using the global variables, You don't need this line if you are using a framework that supports PSR-7
$request = ServerRequest::fromGlobals();

$isVerified = (new Verifier())->verify($request, new Secret('WEBHOOK_SECRET_KEY'));

if ($isVerified) {
    echo "Webhook is verified\n";

    $data = json_decode((string) $request->getBody(), true, JSON_THROW_ON_ERROR);
    $notification = Notification::from($data);
    $id = $notification->id;
    $event = $notification->event;
    $eventId = $event->eventId;
    $eventType = $event->eventType;
    $occurredAt = $event->occurredAt;

    if ($event instanceof TransactionUpdated) {
        $transactionId = $event->transaction->id;
    }
} else {
    echo "Webhook is not verified\n";
}
