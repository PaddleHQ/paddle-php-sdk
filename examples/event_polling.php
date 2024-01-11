<?php

declare(strict_types=1);

use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Events\Operations\ListOperation;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;

require __DIR__ . '/../vendor/autoload.php';

$environment = Paddle\SDK\Environment::tryFrom(getenv('PADDLE_ENVIRONMENT') ?: '') ?? Paddle\SDK\Environment::SANDBOX;
$apiKey = getenv('PADDLE_API_KEY') ?: null;

if (is_null($apiKey)) {
    echo "You must provide the PADDLE_API_KEY in the environment:\n";
    echo "PADDLE_API_KEY=your-key php examples/basic_usage.php\n";
    exit(1);
}

$paddle = new Paddle\SDK\Client($apiKey, options: new Paddle\SDK\Options($environment));

// You would likely here have a event id that you last processed to
// This process would expect to carry on from where it left off
$lastProcessedEventId = 'evt_01hfxx8t6ek9h399srcrp36jt3';

try {
    $events = $paddle->events->list(new ListOperation(new Pager(after: $lastProcessedEventId)));
} catch (ApiError|MalformedResponse $e) {
    // Handle an error, terminate the poll
    var_dump($e->getMessage());
    exit;
}

foreach ($events as $event) {
    // Will read until the most recent event
    $lastProcessedEventId = $event->eventId;

    echo sprintf(
        "event: %s\t\t Type: %s\t\t Occurred At: %s\n",
        $event->eventId,
        str_pad($event->eventType->value, 28),
        $event->occurredAt->format(Paddle\SDK\Entities\DateTime::PADDLE_RFC3339),
    );
}

// Here you're up-to-date, you'd keep a record of where you got to...
