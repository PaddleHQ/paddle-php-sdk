<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Resources\Simulation\Operations;

use Paddle\SDK\Entities\Simulation\SimulationScenarioType;
use Paddle\SDK\Exceptions\SdkExceptions\InvalidArgumentException;
use Paddle\SDK\Resources\Simulations\Operations\Config\SimulationConfigCreate;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Cancellation\SubscriptionCancellationConfig;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Creation\SubscriptionCreationConfig;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Pause\SubscriptionPauseConfig;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Renewal\SubscriptionRenewalConfig;
use Paddle\SDK\Resources\Simulations\Operations\Config\Subscription\Resume\SubscriptionResumeConfig;
use Paddle\SDK\Resources\Simulations\Operations\UpdateSimulation;
use PHPUnit\Framework\TestCase;

class UpdateSimulationTest extends TestCase
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

        new UpdateSimulation(
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
            new SubscriptionCreationConfig(),
        ];

        yield 'SubscriptionPauseConfig' => [
            SimulationScenarioType::SubscriptionRenewal(),
            new SubscriptionPauseConfig(),
        ];

        yield 'SubscriptionRenewalConfig' => [
            SimulationScenarioType::SubscriptionResume(),
            new SubscriptionRenewalConfig(),
        ];

        yield 'SubscriptionResumeConfig' => [
            SimulationScenarioType::SubscriptionCancellation(),
            new SubscriptionResumeConfig(),
        ];

        yield 'SubscriptionCancellationConfig' => [
            SimulationScenarioType::SubscriptionCreation(),
            new SubscriptionCancellationConfig(),
        ];
    }
}
