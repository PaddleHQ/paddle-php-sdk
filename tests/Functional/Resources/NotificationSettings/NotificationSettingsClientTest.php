<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\NotificationSettings;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Event\EventTypeName;
use Paddle\SDK\Entities\NotificationSetting\NotificationSettingType;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\NotificationSettings\Operations\CreateNotificationSetting;
use Paddle\SDK\Resources\NotificationSettings\Operations\UpdateNotificationSetting;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class NotificationSettingsClientTest extends TestCase
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
        CreateNotificationSetting $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->notificationSettings->create($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/notification-settings', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function createOperationsProvider(): \Generator
    {
        yield 'Basic Create' => [
            new CreateNotificationSetting(
                description: 'Slack notifications',
                destination: 'https://hooks.slack.com/example',
                subscribedEvents: [
                    EventTypeName::TransactionBilled(),
                    EventTypeName::TransactionCanceled(),
                    EventTypeName::TransactionCompleted(),
                    EventTypeName::TransactionCreated(),
                    EventTypeName::TransactionPaymentFailed(),
                    EventTypeName::SubscriptionCreated(),
                ],
                type: NotificationSettingType::Url(),
                includeSensitiveFields: false,
            ),
            new Response(200, body: self::readRawJsonFixture('response/minimal_entity')),
            self::readRawJsonFixture('request/create_basic'),
        ];

        yield 'Create with Data' => [
            new CreateNotificationSetting(
                description: 'Slack notifications',
                destination: 'https://hooks.slack.com/example',
                subscribedEvents: [
                    EventTypeName::TransactionBilled(),
                    EventTypeName::TransactionCanceled(),
                    EventTypeName::TransactionCompleted(),
                    EventTypeName::TransactionCreated(),
                    EventTypeName::TransactionPaymentFailed(),
                    EventTypeName::TransactionReady(),
                    EventTypeName::TransactionUpdated(),
                    EventTypeName::SubscriptionActivated(),
                    EventTypeName::SubscriptionCreated(),
                    EventTypeName::SubscriptionPastDue(),
                    EventTypeName::SubscriptionPaused(),
                    EventTypeName::SubscriptionResumed(),
                    EventTypeName::SubscriptionTrialing(),
                    EventTypeName::SubscriptionUpdated(),
                ],
                type: NotificationSettingType::Url(),
                includeSensitiveFields: false,
                apiVersion: 1,
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_full'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider updateOperationsProvider
     */
    public function it_uses_expected_payload_on_update(
        UpdateNotificationSetting $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->notificationSettings->update('ntfset_01gkpjp8bkm3tm53kdgkx6sms7', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/notification-settings/ntfset_01gkpjp8bkm3tm53kdgkx6sms7', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function updateOperationsProvider(): \Generator
    {
        yield 'Update Single' => [
            new UpdateNotificationSetting(active: false),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_single'),
        ];

        yield 'Update Partial' => [
            new UpdateNotificationSetting(description: 'Slack notifications (old)', active: false),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_partial'),
        ];

        yield 'Update All' => [
            new UpdateNotificationSetting(
                description: 'Slack notifications (old)',
                destination: 'https://hooks.slack.com/example',
                active: false,
                apiVersion: 1,
                includeSensitiveFields: false,
                subscribedEvents: [
                    EventTypeName::TransactionBilled(),
                    EventTypeName::TransactionCanceled(),
                    EventTypeName::TransactionCompleted(),
                    EventTypeName::TransactionCreated(),
                    EventTypeName::TransactionPaymentFailed(),
                    EventTypeName::TransactionReady(),
                    EventTypeName::TransactionUpdated(),
                    EventTypeName::SubscriptionActivated(),
                    EventTypeName::SubscriptionCreated(),
                    EventTypeName::SubscriptionPastDue(),
                    EventTypeName::SubscriptionPaused(),
                    EventTypeName::SubscriptionResumed(),
                    EventTypeName::SubscriptionTrialing(),
                    EventTypeName::SubscriptionUpdated(),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/update_full'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider listOperationsProvider
     */
    public function list_hits_expected_uri(
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->notificationSettings->list();
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/notification-settings', Environment::SANDBOX->baseUrl()),
        ];
    }

    /**
     * @test
     *
     * @dataProvider getRequestProvider
     */
    public function get_hits_expected_uri(
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->notificationSettings->get('ntfset_01gkpjp8bkm3tm53kdgkx6sms7');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function getRequestProvider(): \Generator
    {
        yield 'Default' => [
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            sprintf('%s/notification-settings/ntfset_01gkpjp8bkm3tm53kdgkx6sms7', Environment::SANDBOX->baseUrl()),
        ];
    }

    /** @test */
    public function delete_hits_expected_uri(): void
    {
        $expectedUri = sprintf(
            '%s/notification-settings/ntfset_01gkpjp8bkm3tm53kdgkx6sms7',
            Environment::SANDBOX->baseUrl(),
        );

        $this->mockClient->addResponse(new Response(204, body: '{}'));
        $this->client->notificationSettings->delete('ntfset_01gkpjp8bkm3tm53kdgkx6sms7');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('DELETE', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }
}
