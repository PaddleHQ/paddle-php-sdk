<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Account;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Account\Operations\UpdateAccount;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class AccountClientTest extends TestCase
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
    public function get_hits_expected_uri_and_returns_account(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/full_entity')));
        $account = $this->client->account->get();
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/account',
            urldecode((string) $request->getUri()),
        );

        self::assertSame('slr_01k1e8w9df9pz73s399svdkxtg', $account->id);
        self::assertSame('15839', $account->legacyId);
        self::assertSame('AeroEdit Inc.', $account->legalName);
        self::assertSame('AeroEdit', $account->displayName);
        self::assertSame('https://example.com', $account->website);
        self::assertSame('hello@example.com', $account->email);
    }

    /** @test */
    public function get_handles_null_fields(): void
    {
        $this->mockClient->addResponse(new Response(200, body: json_encode([
            'data' => [
                'id' => 'slr_01k1e8w9df9pz73s399svdkxtg',
                'legacy_id' => null,
                'legal_name' => null,
                'display_name' => null,
                'website' => null,
                'email' => null,
            ],
            'meta' => ['request_id' => 'abc'],
        ])));
        $account = $this->client->account->get();

        self::assertSame('slr_01k1e8w9df9pz73s399svdkxtg', $account->id);
        self::assertNull($account->legacyId);
        self::assertNull($account->legalName);
        self::assertNull($account->displayName);
        self::assertNull($account->website);
        self::assertNull($account->email);
    }

    /**
     * @test
     *
     * @dataProvider updateOperationsProvider
     */
    public function it_uses_expected_payload_on_update(
        UpdateAccount $operation,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/updated_entity')));
        $account = $this->client->account->update($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/account',
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
        self::assertSame('billing@example.com', $account->email);
    }

    public static function updateOperationsProvider(): \Generator
    {
        yield 'Update email' => [
            new UpdateAccount(email: 'billing@example.com'),
            self::readRawJsonFixture('request/update_email'),
        ];

        yield 'Update with no fields sends empty body' => [
            new UpdateAccount(),
            '{}',
        ];
    }
}
