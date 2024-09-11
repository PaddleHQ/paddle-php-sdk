<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Events;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Environment;
use Paddle\SDK\Notifications\Entities\Product;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Events\Operations\ListEvents;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class EventsClientTest extends TestCase
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
        ListEvents $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->events->list($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListEvents(),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/events', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListEvents(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/events?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Default Paged with After' => [
            new ListEvents(new Pager(after: 'evt_01h83xenpcfjyhkqr4x214m02x')),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/events?after=evt_01h83xenpcfjyhkqr4x214m02x&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];
    }

    /**
     * @test
     */
    public function list_handles_subscription_events_with_and_without_products(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_default')));
        $events = $this->client->events->list(new ListEvents());
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());

        $subscriptionEvents = array_values(
            array_filter(
                iterator_to_array($events),
                fn ($event) => (string) $event->eventType === 'subscription.updated',
            ),
        );

        $subscriptionEvent = $subscriptionEvents[0];
        self::assertNull($subscriptionEvent->data->items[0]->product);
        self::assertInstanceOf(Product::class, $subscriptionEvent->data->items[1]->product);
    }
}
