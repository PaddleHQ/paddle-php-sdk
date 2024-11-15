<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Entities;

use Paddle\SDK\Entities\Event;
use Paddle\SDK\Notifications\Entities\DeletedPaymentMethod;
use Paddle\SDK\Notifications\Entities\Entity;
use Paddle\SDK\Notifications\Entities\PaymentMethod;
use Paddle\SDK\Notifications\Entities\Shared\SavedPaymentMethodDeletionReason;
use Paddle\SDK\Notifications\Entities\Shared\SavedPaymentMethodOrigin;
use Paddle\SDK\Notifications\Events\PaymentMethodDeleted;
use Paddle\SDK\Notifications\Events\PaymentMethodSaved;
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
        $eventTypeData = [
            [
                'address.created',
                'address',
                \Paddle\SDK\Notifications\Events\AddressCreated::class,
                \Paddle\SDK\Notifications\Entities\Address::class,
            ],
            [
                'address.imported',
                'address',
                \Paddle\SDK\Notifications\Events\AddressImported::class,
                \Paddle\SDK\Notifications\Entities\Address::class,
            ],
            [
                'address.updated',
                'address',
                \Paddle\SDK\Notifications\Events\AddressUpdated::class,
                \Paddle\SDK\Notifications\Entities\Address::class,
            ],
            [
                'adjustment.created',
                'adjustment',
                \Paddle\SDK\Notifications\Events\AdjustmentCreated::class,
                \Paddle\SDK\Notifications\Entities\Adjustment::class,
            ],
            [
                'adjustment.updated',
                'adjustment',
                \Paddle\SDK\Notifications\Events\AdjustmentUpdated::class,
                \Paddle\SDK\Notifications\Entities\Adjustment::class,
            ],
            [
                'business.created',
                'business',
                \Paddle\SDK\Notifications\Events\BusinessCreated::class,
                \Paddle\SDK\Notifications\Entities\Business::class,
            ],
            [
                'business.imported',
                'business',
                \Paddle\SDK\Notifications\Events\BusinessImported::class,
                \Paddle\SDK\Notifications\Entities\Business::class,
            ],
            [
                'business.updated',
                'business',
                \Paddle\SDK\Notifications\Events\BusinessUpdated::class,
                \Paddle\SDK\Notifications\Entities\Business::class,
            ],
            [
                'customer.created',
                'customer',
                \Paddle\SDK\Notifications\Events\CustomerCreated::class,
                \Paddle\SDK\Notifications\Entities\Customer::class,
            ],
            [
                'customer.imported',
                'customer',
                \Paddle\SDK\Notifications\Events\CustomerImported::class,
                \Paddle\SDK\Notifications\Entities\Customer::class,
            ],
            [
                'customer.updated',
                'customer',
                \Paddle\SDK\Notifications\Events\CustomerUpdated::class,
                \Paddle\SDK\Notifications\Entities\Customer::class,
            ],
            [
                'discount.created',
                'discount',
                \Paddle\SDK\Notifications\Events\DiscountCreated::class,
                \Paddle\SDK\Notifications\Entities\Discount::class,
            ],
            [
                'discount.imported',
                'discount',
                \Paddle\SDK\Notifications\Events\DiscountImported::class,
                \Paddle\SDK\Notifications\Entities\Discount::class,
            ],
            [
                'discount.updated',
                'discount',
                \Paddle\SDK\Notifications\Events\DiscountUpdated::class,
                \Paddle\SDK\Notifications\Entities\Discount::class,
            ],
            [
                'payment_method.saved',
                'paymentMethod',
                PaymentMethodSaved::class,
                PaymentMethod::class,
            ],
            [
                'payment_method.deleted',
                'paymentMethod',
                PaymentMethodDeleted::class,
                DeletedPaymentMethod::class,
            ],
            [
                'payout.created',
                'payout',
                \Paddle\SDK\Notifications\Events\PayoutCreated::class,
                \Paddle\SDK\Notifications\Entities\Payout::class,
            ],
            [
                'payout.paid',
                'payout',
                \Paddle\SDK\Notifications\Events\PayoutPaid::class,
                \Paddle\SDK\Notifications\Entities\Payout::class,
            ],
            [
                'price.created',
                'price',
                \Paddle\SDK\Notifications\Events\PriceCreated::class,
                \Paddle\SDK\Notifications\Entities\Price::class,
            ],
            [
                'price.updated',
                'price',
                \Paddle\SDK\Notifications\Events\PriceUpdated::class,
                \Paddle\SDK\Notifications\Entities\Price::class,
            ],
            [
                'price.imported',
                'price',
                \Paddle\SDK\Notifications\Events\PriceImported::class,
                \Paddle\SDK\Notifications\Entities\Price::class,
            ],
            [
                'product.created',
                'product',
                \Paddle\SDK\Notifications\Events\ProductCreated::class,
                \Paddle\SDK\Notifications\Entities\Product::class,
            ],
            [
                'product.updated',
                'product',
                \Paddle\SDK\Notifications\Events\ProductUpdated::class,
                \Paddle\SDK\Notifications\Entities\Product::class,
            ],
            [
                'product.imported',
                'product',
                \Paddle\SDK\Notifications\Events\ProductImported::class,
                \Paddle\SDK\Notifications\Entities\Product::class,
            ],
            [
                'subscription.activated',
                'subscription',
                \Paddle\SDK\Notifications\Events\SubscriptionActivated::class,
                \Paddle\SDK\Notifications\Entities\Subscription::class,
            ],
            [
                'subscription.canceled',
                'subscription',
                \Paddle\SDK\Notifications\Events\SubscriptionCanceled::class,
                \Paddle\SDK\Notifications\Entities\Subscription::class,
            ],
            [
                'subscription.created',
                'subscription',
                \Paddle\SDK\Notifications\Events\SubscriptionCreated::class,
                \Paddle\SDK\Notifications\Entities\Subscription::class,
            ],
            [
                'subscription.imported',
                'subscription',
                \Paddle\SDK\Notifications\Events\SubscriptionImported::class,
                \Paddle\SDK\Notifications\Entities\Subscription::class,
            ],
            [
                'subscription.past_due',
                'subscription',
                \Paddle\SDK\Notifications\Events\SubscriptionPastDue::class,
                \Paddle\SDK\Notifications\Entities\Subscription::class,
            ],
            [
                'subscription.paused',
                'subscription',
                \Paddle\SDK\Notifications\Events\SubscriptionPaused::class,
                \Paddle\SDK\Notifications\Entities\Subscription::class,
            ],
            [
                'subscription.resumed',
                'subscription',
                \Paddle\SDK\Notifications\Events\SubscriptionResumed::class,
                \Paddle\SDK\Notifications\Entities\Subscription::class,
            ],
            [
                'subscription.trialing',
                'subscription',
                \Paddle\SDK\Notifications\Events\SubscriptionTrialing::class,
                \Paddle\SDK\Notifications\Entities\Subscription::class,
            ],
            [
                'subscription.updated',
                'subscription',
                \Paddle\SDK\Notifications\Events\SubscriptionUpdated::class,
                \Paddle\SDK\Notifications\Entities\Subscription::class,
            ],
            [
                'transaction.billed',
                'transaction',
                \Paddle\SDK\Notifications\Events\TransactionBilled::class,
                \Paddle\SDK\Notifications\Entities\Transaction::class,
            ],
            [
                'transaction.canceled',
                'transaction',
                \Paddle\SDK\Notifications\Events\TransactionCanceled::class,
                \Paddle\SDK\Notifications\Entities\Transaction::class,
            ],
            [
                'transaction.completed',
                'transaction',
                \Paddle\SDK\Notifications\Events\TransactionCompleted::class,
                \Paddle\SDK\Notifications\Entities\Transaction::class,
            ],
            [
                'transaction.created',
                'transaction',
                \Paddle\SDK\Notifications\Events\TransactionCreated::class,
                \Paddle\SDK\Notifications\Entities\Transaction::class,
            ],
            [
                'transaction.paid',
                'transaction',
                \Paddle\SDK\Notifications\Events\TransactionPaid::class,
                \Paddle\SDK\Notifications\Entities\Transaction::class,
            ],
            [
                'transaction.past_due',
                'transaction',
                \Paddle\SDK\Notifications\Events\TransactionPastDue::class,
                \Paddle\SDK\Notifications\Entities\Transaction::class,
            ],
            [
                'transaction.payment_failed',
                'transaction',
                \Paddle\SDK\Notifications\Events\TransactionPaymentFailed::class,
                \Paddle\SDK\Notifications\Entities\Transaction::class,
            ],
            [
                'transaction.ready',
                'transaction',
                \Paddle\SDK\Notifications\Events\TransactionReady::class,
                \Paddle\SDK\Notifications\Entities\Transaction::class,
            ],
            [
                'transaction.updated',
                'transaction',
                \Paddle\SDK\Notifications\Events\TransactionUpdated::class,
                \Paddle\SDK\Notifications\Entities\Transaction::class,
            ],
            [
                'report.created',
                'report',
                \Paddle\SDK\Notifications\Events\ReportCreated::class,
                \Paddle\SDK\Notifications\Entities\Report::class,
            ],
            [
                'report.updated',
                'report',
                \Paddle\SDK\Notifications\Events\ReportUpdated::class,
                \Paddle\SDK\Notifications\Entities\Report::class,
            ],
        ];

        foreach ($eventTypeData as [$eventType, $entityProperty, $eventClass, $entityClass]) {
            yield $eventType => [
                $eventType,
                $entityProperty,
                $eventClass,
                $entityClass,
            ];
        }
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
}
