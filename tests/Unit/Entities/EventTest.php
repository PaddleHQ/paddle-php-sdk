<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Entities;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\Business;
use Paddle\SDK\Notifications\Notification\BusinessUpdatedNotification;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class EventTest extends TestCase
{
    use ReadsFixtures;

    /** @test */
    public function it_creates_from_data(): void
    {
        $data = self::readJsonFixture('notification_business_updated');

        $notification = Event::notificationFrom($data);

        self::assertInstanceOf(BusinessUpdatedNotification::class, $notification);

        self::assertSame('ntf_01h8bzam1z32agrxjwhjgqk8w6', $notification->notification_id);

        self::assertSame('evt_01h8bzakzx3hm2fmen703n5q45', $notification->eventId);
        self::assertSame('2023-08-21T11:57:47.390+00:00', $notification->occurredAt->format(DATE_RFC3339_EXTENDED));
        self::assertSame('business.updated', $notification->eventType->getValue());

        $business = $notification->business;
        self::assertInstanceOf(Business::class, $business);
        self::assertSame('biz_01h84a7hr4pzhsajkm8tev89ev', $business->id);
        self::assertSame('ChatApp Inc.', $business->name);
        self::assertSame('active', $business->status->getValue());
    }

    /** @test */
    public function it_creates_from_request(): void
    {
        $requestStream = $this->createMock(StreamInterface::class);
        $requestStream
            ->method('__toString')
            ->willReturn(self::readRawJsonFixture('notification_business_updated'));

        $request = $this->createMock(ServerRequestInterface::class);
        $request
            ->method('getBody')
            ->willReturn($requestStream);

        $notification = Event::notificationFromRequest($request);

        self::assertInstanceOf(BusinessUpdatedNotification::class, $notification);

        self::assertSame('ntf_01h8bzam1z32agrxjwhjgqk8w6', $notification->notification_id);
    }
}
