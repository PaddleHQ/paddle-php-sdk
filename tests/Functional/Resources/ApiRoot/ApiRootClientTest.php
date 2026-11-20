<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\ApiRoot;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\ApiRoot\RootAuthType;
use Paddle\SDK\Entities\ApiRoot\RootEnvironment;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class ApiRootClientTest extends TestCase
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

    /** @test */
    public function get_returns_authenticated_response(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/authenticated')));
        $rootContext = $this->client->apiRoot->get();
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/',
            urldecode((string) $request->getUri()),
        );

        self::assertSame('Paddle API', $rootContext->api->name);
        self::assertSame('1', $rootContext->api->version);
        self::assertEquals(RootEnvironment::Production(), $rootContext->api->environment);
        self::assertSame('https://developer.paddle.com/api-reference/overview', $rootContext->api->documentationUrl);
        self::assertEquals(RootAuthType::ApiKey(), $rootContext->caller->authType);
        self::assertNotNull($rootContext->caller->account);
        self::assertSame('slr_01k1e8w9df9pz73s399svdkxtg', $rootContext->caller->account->id);
        self::assertSame('AeroEdit', $rootContext->caller->account->name);
        self::assertSame(
            ['transaction.read', 'transaction.write', 'subscription.read', 'customer.read'],
            $rootContext->caller->permissions,
        );
    }

    /** @test */
    public function get_returns_unauthenticated_response(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/unauthenticated')));
        $rootContext = $this->client->apiRoot->get();

        self::assertEquals(RootEnvironment::Production(), $rootContext->api->environment);
        self::assertNull($rootContext->caller->authType);
        self::assertNull($rootContext->caller->account);
        self::assertSame([], $rootContext->caller->permissions);
    }
}
