<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Resources\Events\Operations;

use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\Resources\Events\Operations\ListEvents;
use PHPUnit\Framework\TestCase;

class ListEventsTest extends TestCase
{
    /**
     * @test
     */
    public function it_validates_event_types(): void
    {
        self::expectException(InvalidArgumentException::class);
        self::expectExceptionMessage('expected eventTypes to only contain only type/s Paddle\SDK\Entities\Event\EventTypeName, some_invalid.event given');

        new ListEvents(
            eventTypes: ['some_invalid.event'],
        );
    }
}
