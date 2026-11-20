<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Entities\Simulation;

use Paddle\SDK\JsonEncoder;
use Paddle\SDK\Notifications\Entities\Simulation\Subscription;
use PHPUnit\Framework\TestCase;

class SubscriptionDiscountTest extends TestCase
{
    /**
     * @test
     */
    public function it_leaves_out_unset_discount_type_from_simulation_payloads(): void
    {
        $subscription = Subscription::from([
            'id' => 'sub_01h04vsc0qhwtsbsxh3422wjs4',
            'discount' => [
                'id' => 'dsc_01h04vsc0qhwtsbsxh3422wjs4',
                'starts_at' => '2024-04-12T10:18:47.635628Z',
                'ends_at' => null,
            ],
        ]);

        $payload = json_decode(JsonEncoder::default()->encode($subscription), true);

        self::assertSame('dsc_01h04vsc0qhwtsbsxh3422wjs4', $payload['discount']['id']);
        self::assertSame('2024-04-12T10:18:47.635628Z', $payload['discount']['starts_at']);
        self::assertNull($payload['discount']['ends_at']);
        self::assertArrayNotHasKey('type', $payload['discount']);
    }

    /**
     * @test
     */
    public function it_sends_discount_type_in_simulation_payloads(): void
    {
        $subscription = Subscription::from([
            'id' => 'sub_01h04vsc0qhwtsbsxh3422wjs4',
            'discount' => [
                'id' => 'dsc_01h04vsc0qhwtsbsxh3422wjs4',
                'starts_at' => null,
                'ends_at' => null,
                'type' => 'one-off',
            ],
        ]);

        $payload = json_decode(JsonEncoder::default()->encode($subscription), true);

        self::assertSame('one-off', $payload['discount']['type']);
    }
}
