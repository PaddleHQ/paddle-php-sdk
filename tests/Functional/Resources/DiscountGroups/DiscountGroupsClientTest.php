<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\DiscountGroups;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Environment;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\DiscountGroups\Operations\CreateDiscountGroup;
use Paddle\SDK\Resources\DiscountGroups\Operations\ListDiscountGroups;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class DiscountGroupsClientTest extends TestCase
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
        CreateDiscountGroup $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->discountGroups->create($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/discount-groups', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function createOperationsProvider(): \Generator
    {
        yield 'Create with Data' => [
            new CreateDiscountGroup(
                'Black Friday 2024',
            ),
            new Response(201, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/create_full'),
        ];
    }

    /**
     * @test
     */
    public function it_throws_api_error(): void
    {
        $this->expectExceptionMessage('Invalid request');
        $this->expectException(ApiError::class);

        $this->mockClient->addResponse(
            new Response(400, body: json_encode([
                'error' => [
                    'code' => 'bad_request',
                    'type' => 'request_error',
                    'detail' => 'Invalid request',
                    'documentation_url' => 'https://developer.paddle.com/v1/errors/shared/bad_request',
                ],
            ])),
        );

        $this->client->discountGroups->create(
            new CreateDiscountGroup(
                'Some Discount Group',
            ),
        );
    }

    /**
     * @test
     *
     * @dataProvider listOperationsProvider
     */
    public function list_hits_expected_uri(
        ListDiscountGroups $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->discountGroups->list($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListDiscountGroups(),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/discount-groups', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListDiscountGroups(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/discount-groups?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Default Paged with After' => [
            new ListDiscountGroups(new Pager(after: 'dsg_01gtf15svsqzgp9325ss4ebmwt')),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/discount-groups?after=dsg_01gtf15svsqzgp9325ss4ebmwt&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'ID Filtered' => [
            new ListDiscountGroups(ids: ['dsg_01gtf15svsqzgp9325ss4ebmwt']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/discount-groups?id=dsg_01gtf15svsqzgp9325ss4ebmwt', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Multiple ID Filtered' => [
            new ListDiscountGroups(ids: ['dsg_01gtf15svsqzgp9325ss4ebmwt', 'dsg_02gtf15svsqzgp9325ss4ebmwt']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/discount-groups?id=dsg_01gtf15svsqzgp9325ss4ebmwt,dsg_02gtf15svsqzgp9325ss4ebmwt',
                Environment::SANDBOX->baseUrl(),
            ),
        ];
    }
}
