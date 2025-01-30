<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Entities;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\DeletedPaymentMethod;
use Paddle\SDK\Notifications\Entities\Entity;
use Paddle\SDK\Notifications\Entities\PaymentMethod;
use Paddle\SDK\Notifications\Entities\Shared\SavedPaymentMethodDeletionReason;
use Paddle\SDK\Notifications\Entities\Shared\SavedPaymentMethodOrigin;
use Paddle\SDK\Notifications\Entities\UndefinedEntity;
use Paddle\SDK\Notifications\Events\PaymentMethodDeleted;
use Paddle\SDK\Notifications\Events\PaymentMethodSaved;
use Paddle\SDK\Notifications\Events\SubscriptionActivated;
use Paddle\SDK\Notifications\Events\SubscriptionCanceled;
use Paddle\SDK\Tests\DataProvider\EventDataProvider;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;

class EventTest extends TestCase
{
    use ReadsFixtures;

    /**
     * @test
     *
     * @dataProvider eventDataProvider
     */
    public function it_creates_notification_event_from_data(string $eventType, string $entityProperty, string $eventClass, string $entityClass): void
    {
        $event = Event::from([
            'event_id' => 'evt_01h8bzakzx3hm2fmen703n5q45',
            'event_type' => $eventType,
            'occurred_at' => '2023-08-21T11:57:47.390028Z',
            'notification_id' => 'ntf_01h8bzam1z32agrxjwhjgqk8w6',
            'data' => self::readJsonFixture('notification/entity/' . $eventType),
        ]);

        self::assertSame('ntf_01h8bzam1z32agrxjwhjgqk8w6', $event->notificationId);

        self::assertInstanceOf($eventClass, $event);
        self::assertInstanceOf(Entity::class, $event->data);
        self::assertInstanceOf($entityClass, $event->{$entityProperty});
        self::assertSame($event->data, $event->{$entityProperty});
        self::assertSame('evt_01h8bzakzx3hm2fmen703n5q45', $event->eventId);
        self::assertSame('2023-08-21T11:57:47.390+00:00', $event->occurredAt->format(DATE_RFC3339_EXTENDED));
        self::assertSame($eventType, $event->eventType->getValue());
    }

    /**
     * @test
     *
     * @dataProvider eventDataProvider
     */
    public function it_creates_event_from_data(string $eventType, string $entityProperty, string $eventClass, string $entityClass): void
    {
        $event = Event::from([
            'event_id' => 'evt_01h8bzakzx3hm2fmen703n5q45',
            'event_type' => $eventType,
            'occurred_at' => '2023-08-21T11:57:47.390028Z',
            'data' => self::readJsonFixture('notification/entity/' . $eventType),
        ]);

        self::assertNull($event->notificationId);

        self::assertInstanceOf($eventClass, $event);
        self::assertInstanceOf(Entity::class, $event->data);
        self::assertInstanceOf($entityClass, $event->{$entityProperty});
        self::assertSame($event->data, $event->{$entityProperty});
        self::assertSame('evt_01h8bzakzx3hm2fmen703n5q45', $event->eventId);
        self::assertSame('2023-08-21T11:57:47.390+00:00', $event->occurredAt->format(DATE_RFC3339_EXTENDED));
        self::assertSame($eventType, $event->eventType->getValue());
    }

    public static function eventDataProvider(): iterable
    {
        return EventDataProvider::events();
    }

    /**
     * @test
     */
    public function it_creates_event_for_undefined_entity(): void
    {
        $event = Event::from([
            'event_id' => 'evt_01h8bzakzx3hm2fmen703n5q45',
            'event_type' => 'unknown_event.created',
            'occurred_at' => '2023-08-21T11:57:47.390028Z',
            'notification_id' => 'ntf_01h8bzam1z32agrxjwhjgqk8w6',
            'data' => [
                'some' => 'data',
            ],
        ]);

        self::assertSame('ntf_01h8bzam1z32agrxjwhjgqk8w6', $event->notificationId);

        self::assertInstanceOf(Event::class, $event);
        self::assertInstanceOf(Entity::class, $event->data);
        self::assertInstanceOf(UndefinedEntity::class, $event->data);
    }

    /**
     * @test
     */
    public function it_creates_event_for_undefined_event_with_known_entity(): void
    {
        $event = Event::from([
            'event_id' => 'evt_01h8bzakzx3hm2fmen703n5q45',
            'event_type' => 'transaction.unknown_event',
            'occurred_at' => '2023-08-21T11:57:47.390028Z',
            'notification_id' => 'ntf_01h8bzam1z32agrxjwhjgqk8w6',
            'data' => [
                'some' => 'data',
            ],
        ]);

        self::assertSame('ntf_01h8bzam1z32agrxjwhjgqk8w6', $event->notificationId);

        self::assertInstanceOf(Event::class, $event);
        self::assertInstanceOf(Entity::class, $event->data);
        self::assertInstanceOf(UndefinedEntity::class, $event->data);
    }

    /**
     * @test
     */
    public function it_creates_entity_from_data(): void
    {
        $event = Event::from(self::readJsonFixture('notification/business.updated'));

        self::assertSame('ntf_01h8bzam1z32agrxjwhjgqk8w6', $event->notificationId);

        self::assertInstanceOf(\Paddle\SDK\Notifications\Events\BusinessUpdated::class, $event);
        self::assertInstanceOf(Entity::class, $event->data);
        self::assertSame($event->data, $event->business);
        self::assertSame('evt_01h8bzakzx3hm2fmen703n5q45', $event->eventId);
        self::assertSame('2023-08-21T11:57:47.390+00:00', $event->occurredAt->format(DATE_RFC3339_EXTENDED));
        self::assertSame('business.updated', $event->eventType->getValue());

        $business = $event->business;
        self::assertInstanceOf(\Paddle\SDK\Notifications\Entities\Business::class, $business);
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
            ->willReturn(self::readRawJsonFixture('notification/business.updated'));

        $request = $this->createMock(ServerRequestInterface::class);
        $request
            ->method('getBody')
            ->willReturn($requestStream);

        $notification = Event::fromRequest($request);

        self::assertSame('ntf_01h8bzam1z32agrxjwhjgqk8w6', $notification->notificationId);
    }

    /**
     * @test
     */
    public function it_creates_payment_method(): void
    {
        $event = Event::from([
            'event_id' => 'evt_01h8bzakzx3hm2fmen703n5q45',
            'event_type' => 'payment_method.saved',
            'occurred_at' => '2023-08-21T11:57:47.390028Z',
            'notification_id' => 'ntf_01h8bzam1z32agrxjwhjgqk8w6',
            'data' => self::readJsonFixture('notification/entity/payment_method.saved'),
        ]);

        self::assertSame('ntf_01h8bzam1z32agrxjwhjgqk8w6', $event->notificationId);

        self::assertInstanceOf(PaymentMethodSaved::class, $event);
        self::assertInstanceOf(Entity::class, $event->data);
        self::assertSame($event->data, $event->paymentMethod);
        self::assertSame('evt_01h8bzakzx3hm2fmen703n5q45', $event->eventId);
        self::assertSame('2023-08-21T11:57:47.390+00:00', $event->occurredAt->format(DATE_RFC3339_EXTENDED));
        self::assertSame('payment_method.saved', $event->eventType->getValue());

        $paymentMethod = $event->paymentMethod;
        self::assertInstanceOf(PaymentMethod::class, $paymentMethod);

        self::assertSame('paymtd_01hs8zx6x377xfsfrt2bqsevbw', $paymentMethod->id);
        self::assertSame('ctm_01hv6y1jedq4p1n0yqn5ba3ky4', $paymentMethod->customerId);
        self::assertSame('add_01hv8gq3318ktkfengj2r75gfx', $paymentMethod->addressId);
        self::assertEquals(SavedPaymentMethodOrigin::SavedDuringPurchase(), $paymentMethod->origin);
        self::assertSame('2024-05-02T02:55:25.198+00:00', $paymentMethod->savedAt->format(DATE_RFC3339_EXTENDED));
        self::assertSame('2024-05-02T02:55:25.198+00:00', $paymentMethod->updatedAt->format(DATE_RFC3339_EXTENDED));
    }

    /**
     * @test
     */
    public function it_creates_deleted_payment_method(): void
    {
        $event = Event::from([
            'event_id' => 'evt_01h8bzakzx3hm2fmen703n5q45',
            'event_type' => 'payment_method.deleted',
            'occurred_at' => '2023-08-21T11:57:47.390028Z',
            'notification_id' => 'ntf_01h8bzam1z32agrxjwhjgqk8w6',
            'data' => self::readJsonFixture('notification/entity/payment_method.deleted'),
        ]);

        self::assertSame('ntf_01h8bzam1z32agrxjwhjgqk8w6', $event->notificationId);

        self::assertInstanceOf(PaymentMethodDeleted::class, $event);
        self::assertInstanceOf(Entity::class, $event->data);
        self::assertSame($event->data, $event->paymentMethod);
        self::assertSame('evt_01h8bzakzx3hm2fmen703n5q45', $event->eventId);
        self::assertSame('2023-08-21T11:57:47.390+00:00', $event->occurredAt->format(DATE_RFC3339_EXTENDED));
        self::assertSame('payment_method.deleted', $event->eventType->getValue());

        $paymentMethod = $event->paymentMethod;
        self::assertInstanceOf(DeletedPaymentMethod::class, $paymentMethod);

        self::assertSame('paymtd_01hs8zx6x377xfsfrt2bqsevbw', $paymentMethod->id);
        self::assertSame('ctm_01hv6y1jedq4p1n0yqn5ba3ky4', $paymentMethod->customerId);
        self::assertSame('add_01hv8gq3318ktkfengj2r75gfx', $paymentMethod->addressId);
        self::assertEquals(SavedPaymentMethodOrigin::SavedDuringPurchase(), $paymentMethod->origin);
        self::assertEquals(SavedPaymentMethodDeletionReason::ReplacedByNewerVersion(), $paymentMethod->deletionReason);
        self::assertSame('2024-05-02T02:55:25.198+00:00', $paymentMethod->savedAt->format(DATE_RFC3339_EXTENDED));
        self::assertSame('2024-05-03T12:24:18.826+00:00', $paymentMethod->updatedAt->format(DATE_RFC3339_EXTENDED));
    }

    /**
     * @test
     */
    public function it_supports_subscription_discount(): void
    {
        $event = Event::from([
            'event_id' => 'evt_01h8bzakzx3hm2fmen703n5q45',
            'event_type' => 'subscription.activated',
            'occurred_at' => '2023-08-21T11:57:47.390028Z',
            'notification_id' => 'ntf_01h8bzam1z32agrxjwhjgqk8w6',
            'data' => self::readJsonFixture('notification/entity/subscription.activated'),
        ]);

        self::assertSame('ntf_01h8bzam1z32agrxjwhjgqk8w6', $event->notificationId);

        self::assertInstanceOf(SubscriptionActivated::class, $event);
        self::assertInstanceOf(Entity::class, $event->data);
        self::assertSame($event->data, $event->subscription);
        self::assertEquals('2024-04-12T10:18:47+00:00', $event->subscription->discount->startsAt->format(DATE_RFC3339));
        self::assertEquals('2024-05-12T10:18:47+00:00', $event->subscription->discount->endsAt->format(DATE_RFC3339));
    }

    /**
     * @test
     */
    public function it_supports_nullable_subscription_discount_starts_at_and_ends_at(): void
    {
        $event = Event::from([
            'event_id' => 'evt_01h8bzakzx3hm2fmen703n5q45',
            'event_type' => 'subscription.canceled',
            'occurred_at' => '2023-08-21T11:57:47.390028Z',
            'notification_id' => 'ntf_01h8bzam1z32agrxjwhjgqk8w6',
            'data' => self::readJsonFixture('notification/entity/subscription.canceled'),
        ]);

        self::assertSame('ntf_01h8bzam1z32agrxjwhjgqk8w6', $event->notificationId);

        self::assertInstanceOf(SubscriptionCanceled::class, $event);
        self::assertInstanceOf(Entity::class, $event->data);
        self::assertSame($event->data, $event->subscription);
        self::assertNull($event->subscription->discount->startsAt);
        self::assertNull($event->subscription->discount->endsAt);
    }
}
