<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\CustomerPortalSessions;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\CustomerPortalSessions\Operations\CreateCustomerPortalSession;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CustomerPortalSessionsClientTest extends TestCase
{
    use ReadsFixtures;

    private MockClient $mockClient;
    private Client $client;

    public function setUp(): void
    {
        $this->mockClient = new MockClient();
        $this->client = new Client(
            apiKey: 'API_KEY_PLACEHOLDER',
            options: new Options(Environment::SANDBOX),
            httpClient: $this->mockClient);
    }

    /**
     * @test
     *
     * @dataProvider createOperationsProvider
     */
    public function it_uses_expected_payload_on_create(
        CreateCustomerPortalSession $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->customerPortalSessions->create('ctm_01h844p3h41s12zs5mn4axja51', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/customers/ctm_01h844p3h41s12zs5mn4axja51/portal-sessions',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function createOperationsProvider(): \Generator
    {
        yield 'Create portal session with single subscription ID' => [
            new CreateCustomerPortalSession(['sub_01h04vsc0qhwtsbsxh3422wjs4']),
            new Response(201, body: self::readRawJsonFixture('response/full_entity_single')),
            self::readRawJsonFixture('request/create_single'),
        ];

        yield 'Create portal session with multiple subscription IDs' => [
            new CreateCustomerPortalSession(['sub_01h04vsc0qhwtsbsxh3422wjs4', 'sub_02h04vsc0qhwtsbsxh3422wjs4']),
            new Response(201, body: self::readRawJsonFixture('response/full_entity_multiple')),
            self::readRawJsonFixture('request/create_multiple'),
        ];

        yield 'Create portal session with empty subscription IDs' => [
            new CreateCustomerPortalSession([]),
            new Response(201, body: self::readRawJsonFixture('response/full_entity_empty')),
            self::readRawJsonFixture('request/create_empty'),
        ];

        yield 'Create portal session with omitted subscription IDs' => [
            new CreateCustomerPortalSession(),
            new Response(201, body: self::readRawJsonFixture('response/full_entity_empty')),
            '{}',
        ];
    }

    /**
     * @test
     */
    public function it_returns_expected_response_on_create(): void
    {
        $operation = new CreateCustomerPortalSession(['sub_01h04vsc0qhwtsbsxh3422wjs4', 'sub_02h04vsc0qhwtsbsxh3422wjs4']);
        $response = new Response(201, body: self::readRawJsonFixture('response/full_entity_multiple'));

        $this->mockClient->addResponse($response);
        $portalSession = $this->client->customerPortalSessions->create('ctm_01gysfvfy7vqhpzkq8rjmrq7an', $operation);

        self::assertEquals('cpls_01h4ge9r64c22exjsx0fy8b48b', $portalSession->id);
        self::assertEquals('ctm_01gysfvfy7vqhpzkq8rjmrq7an', $portalSession->customerId);
        self::assertEquals('2024-10-25T06:53:58+00:00', $portalSession->createdAt->format(DATE_RFC3339));

        self::assertEquals(
            'https://customer-portal.paddle.com/cpl_01j7zbyqs3vah3aafp4jf62qaw?action=overview&token=pga_eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJjdG1fMDFncm5uNHp0YTVhMW1mMDJqanplN3kyeXMiLCJuYW1lIjoiSm9obiBEb2UiLCJpYXQiOjE3Mjc2NzkyMzh9._oO12IejzdKmyKTwb7BLjmiILkx4_cSyGjXraOBUI_g',
            $portalSession->urls->general->overview,
        );

        self::assertEquals(
            'sub_01h04vsc0qhwtsbsxh3422wjs4',
            $portalSession->urls->subscriptions[0]->id,
        );
        self::assertEquals(
            'https://customer-portal.paddle.com/cpl_01j7zbyqs3vah3aafp4jf62qaw?action=cancel_subscription&subscription_id=sub_01h04vsc0qhwtsbsxh3422wjs4&token=pga_eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJjdG1fMDFncm5uNHp0YTVhMW1mMDJqanplN3kyeXMiLCJuYW1lIjoiSm9obiBEb2UiLCJpYXQiOjE3Mjc2NzkyMzh9._oO12IejzdKmyKTwb7BLjmiILkx4_cSyGjXraOBUI_g',
            $portalSession->urls->subscriptions[0]->cancelSubscription,
        );
        self::assertEquals(
            'https://customer-portal.paddle.com/cpl_01j7zbyqs3vah3aafp4jf62qaw?action=update_subscription_payment_method&subscription_id=sub_01h04vsc0qhwtsbsxh3422wjs4&token=pga_eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJjdG1fMDFncm5uNHp0YTVhMW1mMDJqanplN3kyeXMiLCJuYW1lIjoiSm9obiBEb2UiLCJpYXQiOjE3Mjc2NzkyMzh9._oO12IejzdKmyKTwb7BLjmiILkx4_cSyGjXraOBUI_g',
            $portalSession->urls->subscriptions[0]->updateSubscriptionPaymentMethod,
        );

        self::assertEquals(
            'sub_02h04vsc0qhwtsbsxh3422wjs4',
            $portalSession->urls->subscriptions[1]->id,
        );
        self::assertEquals(
            'https://customer-portal.paddle.com/cpl_01j7zbyqs3vah3aafp4jf62qaw?action=cancel_subscription&subscription_id=sub_02h04vsc0qhwtsbsxh3422wjs4&token=pga_eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJjdG1fMDFncm5uNHp0YTVhMW1mMDJqanplN3kyeXMiLCJuYW1lIjoiSm9obiBEb2UiLCJpYXQiOjE3Mjc2NzkyMzh9._oO12IejzdKmyKTwb7BLjmiILkx4_cSyGjXraOBUI_g',
            $portalSession->urls->subscriptions[1]->cancelSubscription,
        );
        self::assertEquals(
            'https://customer-portal.paddle.com/cpl_01j7zbyqs3vah3aafp4jf62qaw?action=update_subscription_payment_method&subscription_id=sub_02h04vsc0qhwtsbsxh3422wjs4&token=pga_eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiJjdG1fMDFncm5uNHp0YTVhMW1mMDJqanplN3kyeXMiLCJuYW1lIjoiSm9obiBEb2UiLCJpYXQiOjE3Mjc2NzkyMzh9._oO12IejzdKmyKTwb7BLjmiILkx4_cSyGjXraOBUI_g',
            $portalSession->urls->subscriptions[1]->updateSubscriptionPaymentMethod,
        );
    }
}
