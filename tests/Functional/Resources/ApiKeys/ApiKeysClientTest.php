<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\ApiKeys;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\ApiKey;
use Paddle\SDK\Entities\ApiKeyRotation;
use Paddle\SDK\Entities\ApiKeyRotation\ApiKeyRotationStatus;
use Paddle\SDK\Entities\ApiKeyRotationCreated;
use Paddle\SDK\Environment;
use Paddle\SDK\Notifications\Entities\ApiKey\ApiKeyPermission;
use Paddle\SDK\Notifications\Entities\ApiKey\ApiKeyStatus;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\ApiKeys\Operations\CreateApiKeyRotation;
use Paddle\SDK\Resources\ApiKeys\Operations\ListApiKeyRotations;
use Paddle\SDK\Resources\ApiKeys\Operations\ListApiKeys;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class ApiKeysClientTest extends TestCase
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
        ListApiKeys $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->apiKeys->list($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListApiKeys(),
            new Response(200, body: self::readRawJsonFixture('response/list_page_one')),
            sprintf('%s/api-keys', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListApiKeys(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_page_one')),
            sprintf('%s/api-keys?order_by=id[asc]&per_page=50', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Paged with After' => [
            new ListApiKeys(new Pager(after: 'apikey_01jkdpbhazdpn3wpcya45as9tg')),
            new Response(200, body: self::readRawJsonFixture('response/list_page_one')),
            sprintf('%s/api-keys?after=apikey_01jkdpbhazdpn3wpcya45as9tg&order_by=id[asc]&per_page=50', Environment::SANDBOX->baseUrl()),
        ];
    }

    /** @test */
    public function list_parses_entities(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_page_one')));
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_page_two')));

        $apiKeys = iterator_to_array($this->client->apiKeys->list(), false);

        self::assertCount(3, $apiKeys);
        self::assertContainsOnlyInstancesOf(ApiKey::class, $apiKeys);
        self::assertSame('apikey_01jkdpbhazdpn3wpcya45as9tg', $apiKeys[0]->id);
        self::assertEquals(ApiKeyStatus::Active(), $apiKeys[0]->status);
        self::assertEquals(ApiKeyStatus::Expired(), $apiKeys[1]->status);
        self::assertNull($apiKeys[1]->description);
    }

    /** @test */
    public function it_can_paginate(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_page_one')));
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_page_two')));

        $collection = $this->client->apiKeys->list();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/api-keys',
            urldecode((string) $this->mockClient->getLastRequest()->getUri()),
        );

        self::assertCount(3, iterator_to_array($collection, false));

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/api-keys?after=apikey_02jkdpbhazdpn3wpcya45as9tg',
            urldecode((string) $this->mockClient->getLastRequest()->getUri()),
        );
    }

    /** @test */
    public function get_hits_expected_uri(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/full_entity')));
        $apiKey = $this->client->apiKeys->get('apikey_01jkdpbhazdpn3wpcya45as9tg');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            sprintf('%s/api-keys/apikey_01jkdpbhazdpn3wpcya45as9tg', Environment::SANDBOX->baseUrl()),
            urldecode((string) $request->getUri()),
        );

        self::assertInstanceOf(ApiKey::class, $apiKey);
        self::assertSame('apikey_01jkdpbhazdpn3wpcya45as9tg', $apiKey->id);
        self::assertSame('CRM integration', $apiKey->name);
        self::assertSame('Used to authenticate with the API for storing Paddle customer data in our CRM.', $apiKey->description);
        self::assertSame('pdl_live_apikey_01jkdpbhaz****', $apiKey->key);
        self::assertEquals(ApiKeyStatus::Active(), $apiKey->status);
        self::assertEquals(
            [ApiKeyPermission::AddressRead(), ApiKeyPermission::ApiKeyRead(), ApiKeyPermission::CustomerRead(), ApiKeyPermission::TransactionRead()],
            $apiKey->permissions,
        );
        self::assertNull($apiKey->exposedAt);
        self::assertSame('2026-03-26T06:58:38.517+00:00', $apiKey->expiresAt->format(DATE_RFC3339_EXTENDED));
        self::assertTrue($apiKey->rotatable);
        self::assertSame('2025-10-20T09:12:44.000+00:00', $apiKey->lastUsedAt->format(DATE_RFC3339_EXTENDED));
        self::assertSame('2025-03-26T06:58:38.517+00:00', $apiKey->createdAt->format(DATE_RFC3339_EXTENDED));
        self::assertSame('2025-03-26T06:58:38.517+00:00', $apiKey->updatedAt->format(DATE_RFC3339_EXTENDED));
    }

    /** @test */
    public function get_parses_legacy_key_with_null_permissions(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/legacy_entity')));
        $apiKey = $this->client->apiKeys->get('apikey_01jkdpbhazdpn3wpcya45as9th');

        self::assertNull($apiKey->permissions);
        self::assertNull($apiKey->description);
        self::assertNull($apiKey->expiresAt);
        self::assertNull($apiKey->lastUsedAt);
        self::assertFalse($apiKey->rotatable);
        self::assertEquals(ApiKeyStatus::Revoked(), $apiKey->status);
        self::assertSame('2025-08-01T10:00:00.000+00:00', $apiKey->exposedAt->format(DATE_RFC3339_EXTENDED));
    }

    /**
     * @test
     *
     * @dataProvider listRotationsOperationsProvider
     */
    public function list_rotations_hits_expected_uri(
        ListApiKeyRotations $operation,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/rotation_list_page_one')));
        $this->client->apiKeys->listRotations('apikey_01jkdpbhazdpn3wpcya45as9tg', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listRotationsOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListApiKeyRotations(),
            sprintf('%s/api-keys/apikey_01jkdpbhazdpn3wpcya45as9tg/rotations', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Paged with After' => [
            new ListApiKeyRotations(new Pager(after: 'apkrot_01kjnm4a3w4jqdbtqvb2jwjdf7', perPage: 10)),
            sprintf('%s/api-keys/apikey_01jkdpbhazdpn3wpcya45as9tg/rotations?after=apkrot_01kjnm4a3w4jqdbtqvb2jwjdf7&order_by=id[asc]&per_page=10', Environment::SANDBOX->baseUrl()),
        ];
    }

    /** @test */
    public function list_rotations_parses_entities_and_paginates(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/rotation_list_page_one')));
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/rotation_list_page_two')));

        $collection = $this->client->apiKeys->listRotations('apikey_01jkdpbhazdpn3wpcya45as9tg');
        $rotations = iterator_to_array($collection, false);

        self::assertCount(3, $rotations);
        self::assertContainsOnlyInstancesOf(ApiKeyRotation::class, $rotations);
        self::assertEquals(ApiKeyRotationStatus::Completed(), $rotations[0]->status);
        self::assertEquals(ApiKeyRotationStatus::Canceled(), $rotations[1]->status);
        self::assertEquals(ApiKeyRotationStatus::Pending(), $rotations[2]->status);
        self::assertNull($rotations[1]->expiresAt);

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/api-keys/apikey_01jkdpbhazdpn3wpcya45as9tg/rotations?after=apkrot_02kjnm4a3w4jqdbtqvb2jwjdf7',
            urldecode((string) $this->mockClient->getLastRequest()->getUri()),
        );
    }

    /** @test */
    public function get_rotation_hits_expected_uri(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/rotation_entity')));
        $rotation = $this->client->apiKeys->getRotation('apikey_01jkdpbhazdpn3wpcya45as9tg', 'apkrot_01kjnm4a3w4jqdbtqvb2jwjdf7');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            sprintf('%s/api-keys/apikey_01jkdpbhazdpn3wpcya45as9tg/rotations/apkrot_01kjnm4a3w4jqdbtqvb2jwjdf7', Environment::SANDBOX->baseUrl()),
            urldecode((string) $request->getUri()),
        );

        self::assertInstanceOf(ApiKeyRotation::class, $rotation);
        self::assertSame('apkrot_01kjnm4a3w4jqdbtqvb2jwjdf7', $rotation->id);
        self::assertSame('apikey_01jkdpbhazdpn3wpcya45as9tg', $rotation->apiKeyId);
        self::assertSame('pdl_live_apikey_01jkdpbhaz****', $rotation->newKey);
        self::assertSame(3600, $rotation->gracePeriodSeconds);
        self::assertSame('2026-11-02T00:00:00.000+00:00', $rotation->newKeyExpiresAt->format(DATE_RFC3339_EXTENDED));
        self::assertSame('2026-10-02T10:05:00.000+00:00', $rotation->expiresAt->format(DATE_RFC3339_EXTENDED));
        self::assertEquals(ApiKeyRotationStatus::Completed(), $rotation->status);
        self::assertSame('2026-10-02T09:00:00.000+00:00', $rotation->createdAt->format(DATE_RFC3339_EXTENDED));
        self::assertSame('2026-10-02T09:05:00.000+00:00', $rotation->updatedAt->format(DATE_RFC3339_EXTENDED));
    }

    /**
     * @test
     *
     * @dataProvider createRotationOperationsProvider
     */
    public function it_uses_expected_payload_on_create_rotation(
        CreateApiKeyRotation $operation,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse(new Response(201, body: self::readRawJsonFixture('response/rotation_created_entity')));
        $rotation = $this->client->apiKeys->createRotation('apikey_01jkdpbhazdpn3wpcya45as9tg', $operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/api-keys/apikey_01jkdpbhazdpn3wpcya45as9tg/rotations',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());

        self::assertInstanceOf(ApiKeyRotationCreated::class, $rotation);
        self::assertSame('apkrot_01kjnm4a3w4jqdbtqvb2jwjdf7', $rotation->id);
        self::assertSame('apikey_01jkdpbhazdpn3wpcya45as9tg', $rotation->apiKeyId);
        self::assertSame('pdl_live_apikey_01kjnm4a3w4jqdbtqvb2jwjdf7_somesecret_abc', $rotation->newKey);
        self::assertSame(3600, $rotation->gracePeriodSeconds);
        self::assertSame('2026-11-02T00:00:00.000+00:00', $rotation->newKeyExpiresAt->format(DATE_RFC3339_EXTENDED));
        self::assertNull($rotation->expiresAt);
        self::assertEquals(ApiKeyRotationStatus::Pending(), $rotation->status);
    }

    public static function createRotationOperationsProvider(): \Generator
    {
        yield 'Basic' => [
            new CreateApiKeyRotation(gracePeriodSeconds: 0),
            self::readRawJsonFixture('request/create_rotation_basic'),
        ];

        yield 'Full with DateTime' => [
            new CreateApiKeyRotation(
                gracePeriodSeconds: 3600,
                newKeyExpiresAt: new \DateTimeImmutable('2026-11-02T00:00:00Z'),
            ),
            self::readRawJsonFixture('request/create_rotation_full'),
        ];

        yield 'Full with string' => [
            new CreateApiKeyRotation(
                gracePeriodSeconds: 3600,
                newKeyExpiresAt: '2026-11-02T00:00:00Z',
            ),
            self::readRawJsonFixture('request/create_rotation_string_expiry'),
        ];
    }
}
