<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\ClientTokens;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\ClientToken\ClientTokenStatus;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\ClientTokens\Operations\CreateClientToken;
use Paddle\SDK\Resources\ClientTokens\Operations\ListClientTokens;
use Paddle\SDK\Resources\ClientTokens\Operations\UpdateClientToken;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ClientTokensClientTest extends TestCase
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
        CreateClientToken $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->clientTokens->create($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/client-tokens', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function createOperationsProvider(): \Generator
    {
        yield 'Basic Create' => [
            new CreateClientToken('Pricing page integration'),
            new Response(200, body: self::readRawJsonFixture('response/minimal_entity')),
            self::readRawJsonFixture('request/create_basic'),
        ];

        yield 'Create with Data' => [
            new CreateClientToken(
                name: 'Pricing page integration',
                description: null,
            ),
            new Response(200, body: self::readRawJsonFixture('response/minimal_entity')),
            self::readRawJsonFixture('request/create_null_description'),
        ];

        yield 'Create with full data' => [
            new CreateClientToken(
                name: 'Pricing page integration',
                description: 'Used to display prices and open checkout within our pricing page on our marketing domain.',
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
        UpdateClientToken $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->clientTokens->update('ctkn_01ghbkd0frb9k95cnhwd1bxpvk', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/client-tokens/ctkn_01ghbkd0frb9k95cnhwd1bxpvk', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function updateOperationsProvider(): \Generator
    {
        yield 'Revoked client token' => [
            new UpdateClientToken(status: ClientTokenStatus::Revoked()),
            new Response(200, body: self::readRawJsonFixture('response/revoked_entity')),
            self::readRawJsonFixture('request/revoke'),
        ];
    }

    /**
     * @test
     *
     * @dataProvider listOperationsProvider
     */
    public function list_hits_expected_uri(
        ListClientTokens $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->clientTokens->list($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListClientTokens(),
            new Response(200, body: self::readRawJsonFixture('response/list_page_one')),
            sprintf('%s/client-tokens', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListClientTokens(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_page_one')),
            sprintf(
                '%s/client-tokens?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Default Paged with After' => [
            new ListClientTokens(new Pager(after: 'ctkn_01ghbkd0frb9k95cnhwd1bxpvk')),
            new Response(200, body: self::readRawJsonFixture('response/list_page_one')),
            sprintf(
                '%s/client-tokens?after=ctkn_01ghbkd0frb9k95cnhwd1bxpvk&order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'Status Filtered - active' => [
            new ListClientTokens(statuses: [ClientTokenStatus::Active()]),
            new Response(200, body: self::readRawJsonFixture('response/list_page_one')),
            sprintf('%s/client-tokens?status=active', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Status Filtered - revoked' => [
            new ListClientTokens(statuses: [ClientTokenStatus::Revoked()]),
            new Response(200, body: self::readRawJsonFixture('response/list_page_one')),
            sprintf('%s/client-tokens?status=revoked', Environment::SANDBOX->baseUrl()),
        ];
    }

    /** @test */
    public function it_can_paginate(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_page_one')));
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_page_two')));

        $collection = $this->client->clientTokens->list();

        $request = $this->mockClient->getLastRequest();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/client-tokens',
            urldecode((string) $request->getUri()),
        );

        $allClientTokens = iterator_to_array($collection);
        self::assertCount(6, $allClientTokens);

        $request = $this->mockClient->getLastRequest();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/client-tokens?after=ctkn_03ghbkd0frb9k95cnhwd1bxpvk',
            urldecode((string) $request->getUri()),
        );
    }

    /** @test */
    public function get_hits_expected_uri(): void
    {
        $response = new Response(200, body: self::readRawJsonFixture('response/full_entity'));
        $this->mockClient->addResponse($response);
        $this->client->clientTokens->get('ctkn_01ghbkd0frb9k95cnhwd1bxpvk');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            sprintf('%s/client-tokens/ctkn_01ghbkd0frb9k95cnhwd1bxpvk', Environment::SANDBOX->baseUrl()),
            urldecode((string) $request->getUri()),
        );
    }

    /**
     * @test
     */
    public function it_uses_expected_payload_on_revoke(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/revoked_entity')));
        $this->client->clientTokens->revoke('ctkn_01ghbkd0frb9k95cnhwd1bxpvk');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/client-tokens/ctkn_01ghbkd0frb9k95cnhwd1bxpvk', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString(
            self::readRawJsonFixture('request/revoke'),
            (string) $request->getBody(),
        );
    }
}
