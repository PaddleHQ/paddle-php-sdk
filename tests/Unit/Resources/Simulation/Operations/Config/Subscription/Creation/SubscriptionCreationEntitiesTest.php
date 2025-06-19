<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Resources\Simulation\Operations\Config\Subscription\Creation;

use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Creation\SubscriptionCreationEntitiesCreate;
use PHPUnit\Framework\TestCase;

class SubscriptionCreationEntitiesTest extends TestCase
{
    /**
     * @test
     */
    public function it_validates_items_and_transaction_id(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('transactionId is not compatible with items');

        new SubscriptionCreationEntitiesCreate(
            transactionId: 'txn_01gsz4s0w61y0pp88528f1wvvb',
            items: [],
        );
    }
}
