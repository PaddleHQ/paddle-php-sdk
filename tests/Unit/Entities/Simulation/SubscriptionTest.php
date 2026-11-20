<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit\Entities\Simulation;

use Paddle\SDK\JsonEncoder;
use Paddle\SDK\Notifications\Entities\Simulation\Subscription;
use Paddle\SDK\Notifications\Entities\Subscription\SubscriptionConsentRequirement;
use Paddle\SDK\Notifications\Entities\Subscription\SubscriptionConsentRequirementStatus;
use Paddle\SDK\Notifications\Entities\Subscription\SubscriptionConsentRequirementType;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use Paddle\SDK\Undefined;
use PHPUnit\Framework\TestCase;

class SubscriptionTest extends TestCase
{
    use ReadsFixtures;

    /**
     * @test
     */
    public function it_supports_consent_requirements(): void
    {
        $data = self::readJsonFixture('notification/entity/subscription.created');
        $data['consent_requirements'] = [
            [
                'id' => 'subconreq_01hp463gxfvndqjjyqn2n7tkth',
                'requirement' => 'trial_ending',
                'status' => 'pending',
                'created_at' => '2024-02-08T11:02:04.975Z',
                'consent_period' => [
                    'starts_at' => '2024-02-08T11:02:03.946454Z',
                    'ends_at' => '2024-03-08T11:02:03.946454Z',
                ],
                'granted_at' => null,
                'voided_at' => null,
            ],
        ];

        $subscription = Subscription::from($data);

        self::assertIsArray($subscription->consentRequirements);
        self::assertCount(1, $subscription->consentRequirements);
        $consentRequirement = $subscription->consentRequirements[0];
        self::assertInstanceOf(SubscriptionConsentRequirement::class, $consentRequirement);
        self::assertSame('subconreq_01hp463gxfvndqjjyqn2n7tkth', $consentRequirement->id);
        self::assertEquals(SubscriptionConsentRequirementType::TrialEnding(), $consentRequirement->requirement);
        self::assertEquals(SubscriptionConsentRequirementStatus::Pending(), $consentRequirement->status);

        $payload = json_decode(JsonEncoder::default()->encode($subscription), true);
        self::assertSame('subconreq_01hp463gxfvndqjjyqn2n7tkth', $payload['consent_requirements'][0]['id']);
        self::assertSame('trial_ending', $payload['consent_requirements'][0]['requirement']);
    }

    /**
     * @test
     */
    public function it_leaves_out_unset_consent_requirements(): void
    {
        $subscription = new Subscription(id: 'sub_01h04vsc0qhwtsbsxh3422wjs4');

        self::assertInstanceOf(Undefined::class, $subscription->consentRequirements);

        $payload = json_decode(JsonEncoder::default()->encode($subscription), true);
        self::assertArrayNotHasKey('consent_requirements', $payload);
    }
}
