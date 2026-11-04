<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\IpAddresses;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\IpAddresses;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class IpAddressesClientTest extends TestCase
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
    public function get_hits_expected_uri_and_returns_ip_addresses(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/ips')));
        $ipAddresses = $this->client->ipAddresses->get();
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/ips',
            urldecode((string) $request->getUri()),
        );

        self::assertInstanceOf(IpAddresses::class, $ipAddresses);
        self::assertSame(
            ['34.194.127.46/32', '54.234.237.108/32', '3.208.120.145/32'],
            $ipAddresses->ipv4Cidrs,
        );
    }
}
