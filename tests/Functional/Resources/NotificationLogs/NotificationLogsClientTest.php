<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\NotificationLogs;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\NotificationLogs\Operations\ListOperation;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class NotificationLogsClientTest extends TestCase
{
    use ReadsFixtures;

    private const TEST_ID = 'ntf_01hher6hqs35t9dzq84g3ggqvh';

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
        ListOperation $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->notificationLogs->list(self::TEST_ID, $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListOperation(),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/notifications/%s/logs', Environment::SANDBOX->baseUrl(), self::TEST_ID),
        ];

        yield 'Default Paged' => [
            new ListOperation(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/notifications/%s/logs?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
                self::TEST_ID,
            ),
        ];

        yield 'Default Paged with After' => [
            new ListOperation(new Pager(after: 'pro_01gsz4s0w61y0pp88528f1wvvb')),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/notifications/%s/logs?after=pro_01gsz4s0w61y0pp88528f1wvvb&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
                self::TEST_ID,
            ),
        ];
    }
}
