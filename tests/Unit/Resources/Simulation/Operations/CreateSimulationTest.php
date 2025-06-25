<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Resources\Simulation\Operations;

use Paddle\SDK\Entities\Simulation\SimulationScenarioType;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\Resources\Simulations\Operations\Config\SimulationConfigCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Cancellation\SubscriptionCancellationConfigCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Creation\SubscriptionCreationConfigCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Pause\SubscriptionPauseConfigCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Renewal\SubscriptionRenewalConfigCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Resume\SubscriptionResumeConfigCreate;
use Paddle\SDK\Resources\Simulations\Operations\CreateSimulation;
use PHPUnit\Framework\TestCase;

class CreateSimulationTest extends TestCase
{
    /**
     * @test
     *
     * @dataProvider incompatibleConfigProvider
     */
    public function it_validates_config_for_type(
        SimulationScenarioType $type,
        SimulationConfigCreate $config,
    ): void {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('config is not compatible with type: %s', $type));

        new CreateSimulation(
            notificationSettingId: 'nftset_01h83xenpcfjyhkqr4x214m02',
            type: $type,
            name: 'Some Simulation',
            config: $config,
        );
    }

    public static function incompatibleConfigProvider(): iterable
    {
        yield 'SubscriptionCreationConfig' => [
            SimulationScenarioType::SubscriptionPause(),
            new SubscriptionCreationConfigCreate(),
        ];

        yield 'SubscriptionPauseConfig' => [
            SimulationScenarioType::SubscriptionRenewal(),
            new SubscriptionPauseConfigCreate(),
        ];

        yield 'SubscriptionRenewalConfig' => [
            SimulationScenarioType::SubscriptionResume(),
            new SubscriptionRenewalConfigCreate(),
        ];

        yield 'SubscriptionResumeConfig' => [
            SimulationScenarioType::SubscriptionCancellation(),
            new SubscriptionResumeConfigCreate(),
        ];

        yield 'SubscriptionCancellationConfig' => [
            SimulationScenarioType::SubscriptionCreation(),
            new SubscriptionCancellationConfigCreate(),
        ];
    }
}
