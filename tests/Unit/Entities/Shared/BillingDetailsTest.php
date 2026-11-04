<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Entities\Shared;

use Paddle\SDK\Entities\Shared\BillingDetails;
use Paddle\SDK\Notifications\Entities\Shared\BillingDetails as NotificationBillingDetails;
use PHPUnit\Framework\TestCase;

class BillingDetailsTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider billingDetailsClassProvider
     *
     * @param class-string<BillingDetails|NotificationBillingDetails> $class
     */
    public function it_supports_missing_optional_fields(string $class): void
    {
        $billingDetails = $class::from([
            'enable_checkout' => false,
            'payment_terms' => ['interval' => 'day', 'frequency' => 30],
        ]);

        self::assertFalse($billingDetails->enableCheckout);
        self::assertSame(30, $billingDetails->paymentTerms->frequency);
        self::assertNull($billingDetails->purchaseOrderNumber);
        self::assertNull($billingDetails->additionalInformation);
    }

    /**
     * @test
     *
     * @dataProvider billingDetailsClassProvider
     *
     * @param class-string<BillingDetails|NotificationBillingDetails> $class
     */
    public function it_supports_all_fields(string $class): void
    {
        $billingDetails = $class::from([
            'enable_checkout' => true,
            'payment_terms' => ['interval' => 'month', 'frequency' => 1],
            'purchase_order_number' => 'PO-123',
            'additional_information' => 'Some information',
        ]);

        self::assertTrue($billingDetails->enableCheckout);
        self::assertSame('PO-123', $billingDetails->purchaseOrderNumber);
        self::assertSame('Some information', $billingDetails->additionalInformation);
    }

    public static function billingDetailsClassProvider(): \Generator
    {
        yield 'API' => [BillingDetails::class];
        yield 'Notification' => [NotificationBillingDetails::class];
    }
}
