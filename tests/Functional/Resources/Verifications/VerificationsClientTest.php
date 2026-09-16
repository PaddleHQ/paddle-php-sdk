<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Verifications;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Verification\VerificationType;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Resources\Verifications\Operations\ListVerifications;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class VerificationsClientTest extends TestCase
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
        ListVerifications $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->verifications->list($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListVerifications(),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/verifications', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListVerifications(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/verifications?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'ID Filtered' => [
            new ListVerifications(ids: ['slrvrf_01jjr5d4c14h4y3lqlk9bedkw7']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/verifications?id=slrvrf_01jjr5d4c14h4y3lqlk9bedkw7', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Verification Type Filtered' => [
            new ListVerifications(verificationType: VerificationType::Domain()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/verifications?verification_type=domain', Environment::SANDBOX->baseUrl()),
        ];
    }

    /** @test */
    public function get_hits_expected_uri(): void
    {
        $response = new Response(200, body: self::readRawJsonFixture('response/full_entity'));
        $this->mockClient->addResponse($response);
        $this->client->verifications->get('slrvrf_01jjr5d4c14h4y3lqlk9bedkw7');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            sprintf('%s/verifications/slrvrf_01jjr5d4c14h4y3lqlk9bedkw7', Environment::SANDBOX->baseUrl()),
            urldecode((string) $request->getUri()),
        );
    }
}
