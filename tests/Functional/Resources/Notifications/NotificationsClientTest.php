<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Notifications;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\DateTime;
use Paddle\SDK\Entities\Notification;
use Paddle\SDK\Entities\Notification\NotificationStatus;
use Paddle\SDK\Environment;
use Paddle\SDK\Notifications\Entities\Entity;
use Paddle\SDK\Notifications\Entities\Transaction;
use Paddle\SDK\Notifications\Entities\UndefinedEntity;
use Paddle\SDK\Notifications\Events\TransactionRevised;
use Paddle\SDK\Notifications\Events\UndefinedEvent;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Notifications\Operations\ListNotifications;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class NotificationsClientTest extends TestCase
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
     * @dataProvider listOperationsProvider
     */
    public function list_hits_expected_uri(
        ListNotifications $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->notifications->list($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListNotifications(),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/notifications', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListNotifications(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/notifications?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Default Paged with After' => [
            new ListNotifications(new Pager(after: 'nft_01h83xenpcfjyhkqr4x214m02x')),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/notifications?after=nft_01h83xenpcfjyhkqr4x214m02x&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Notification Setting ID Filtered' => [
            new ListNotifications(notificationSettingIds: ['nftset_01h83xenpcfjyhkqr4x214m02']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/notifications?notification_setting_id=nftset_01h83xenpcfjyhkqr4x214m02', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple Notification Setting ID Filtered' => [
            new ListNotifications(notificationSettingIds: ['nftset_01h83xenpcfjyhkqr4x214m02', 'nftset_01h8brhckjd6qk4n7e4py2340t']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/notifications?notification_setting_id=nftset_01h83xenpcfjyhkqr4x214m02,nftset_01h8brhckjd6qk4n7e4py2340t',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'NotificationStatus Filtered' => [
            new ListNotifications(statuses: [NotificationStatus::Delivered()]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/notifications?status=delivered', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple NotificationStatus Filtered' => [
            new ListNotifications(statuses: [NotificationStatus::Delivered(), NotificationStatus::NotAttempted()]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/notifications?status=delivered,not_attempted', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Filter Filtered' => [
            new ListNotifications(filter: 'txn_01h83xenpcfjyhkqr4x214m02'),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/notifications?filter=txn_01h83xenpcfjyhkqr4x214m02', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Search Filtered' => [
            new ListNotifications(search: 'transaction.created'),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/notifications?search=transaction.created', Environment::SANDBOX->baseUrl()),
        ];

        yield 'To Filtered' => [
            new ListNotifications(to: new \DateTime('2023-12-25T00:00:00.000Z')),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/notifications?to=2023-12-25T00:00:00.000000Z', Environment::SANDBOX->baseUrl()),
        ];

        yield 'From Filtered' => [
            new ListNotifications(from: new \DateTime('2023-12-24T00:00:00.000Z')),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/notifications?from=2023-12-24T00:00:00.000000Z', Environment::SANDBOX->baseUrl()),
        ];

        yield 'To and From Filtered' => [
            new ListNotifications(
                to: new \DateTime('2023-12-25T00:00:00.000Z'),
                from: new \DateTime('2023-12-24T00:00:00.000Z'),
            ),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/notifications?to=2023-12-25T00:00:00.000000Z&from=2023-12-24T00:00:00.000000Z', Environment::SANDBOX->baseUrl()),
        ];
    }

    /** @test */
    public function get_hits_expected_uri(): void
    {
        $response = new Response(200, body: self::readRawJsonFixture('response/full_entity'));
        $this->mockClient->addResponse($response);
        $this->client->notifications->get('nft_01h8441jn5pcwrfhwh78jqt8hk');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            sprintf('%s/notifications/nft_01h8441jn5pcwrfhwh78jqt8hk', Environment::SANDBOX->baseUrl()),
            urldecode((string) $request->getUri()),
        );
    }

    /** @test */
    public function replay_hits_expected_uri(): void
    {
        $response = new Response(200, body: self::readRawJsonFixture('response/replay'));
        $this->mockClient->addResponse($response);
        $replayId = $this->client->notifications->replay('nft_01h8441jn5pcwrfhwh78jqt8hk');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(
            sprintf('%s/notifications/nft_01h8441jn5pcwrfhwh78jqt8hk/replay', Environment::SANDBOX->baseUrl()),
            urldecode((string) $request->getUri()),
        );
        self::assertSame('ntf_01h46h1s2zabpkdks7yt4vkgkc', $replayId);
    }

    /**
     * @test
     */
    public function list_handles_unknown_events(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_default')));
        $notifications = $this->client->notifications->list(new ListNotifications());
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());

        $undefinedEventNotifications = array_values(
            array_filter(
                iterator_to_array($notifications),
                fn (Notification $notification) => (string) $notification->type === 'unknown_entity.updated',
            ),
        );

        $undefinedEventNotification = $undefinedEventNotifications[0];
        self::assertInstanceOf(Notification::class, $undefinedEventNotification);

        $undefinedEvent = $undefinedEventNotification->payload;
        self::assertInstanceOf(UndefinedEvent::class, $undefinedEvent);
        self::assertSame($undefinedEvent->entity, $undefinedEvent->data);
        self::assertInstanceOf(Entity::class, $undefinedEvent->data);
        self::assertInstanceOf(UndefinedEntity::class, $undefinedEvent->data);
        self::assertInstanceOf(UndefinedEntity::class, $undefinedEvent->entity);
        self::assertEquals(
            [
                'key' => 'value',
            ],
            $undefinedEvent->entity->data,
        );
    }

    /**
     * @test
     */
    public function list_transaction_revised_notification(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_default')));
        $notifications = $this->client->notifications->list(new ListNotifications());

        $transactionRevisedNotifications = array_values(
            array_filter(
                iterator_to_array($notifications),
                fn (Notification $notification) => (string) $notification->type === 'transaction.revised',
            ),
        );

        $transactionRevisedNotification = $transactionRevisedNotifications[0];
        self::assertInstanceOf(Notification::class, $transactionRevisedNotification);

        $transactionRevisedEvent = $transactionRevisedNotification->payload;
        self::assertInstanceOf(TransactionRevised::class, $transactionRevisedEvent);
        self::assertSame($transactionRevisedEvent->transaction, $transactionRevisedEvent->data);
        self::assertInstanceOf(Entity::class, $transactionRevisedEvent->data);
        self::assertInstanceOf(Transaction::class, $transactionRevisedEvent->data);
        self::assertInstanceOf(Transaction::class, $transactionRevisedEvent->transaction);
        self::assertEquals(
            '2024-04-12T10:18:50.738972Z',
            $transactionRevisedEvent->transaction->revisedAt->format(DateTime::PADDLE_RFC3339),
        );
    }
}
