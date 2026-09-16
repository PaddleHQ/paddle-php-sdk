<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\CheckoutDomains;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\CheckoutDomain\CheckoutDomainApprovalStatus;
use Paddle\SDK\Entities\CheckoutDomain\CheckoutDomainPaymentMethod;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\CheckoutDomains\Operations\ListCheckoutDomains;
use Paddle\SDK\Resources\CheckoutDomains\Operations\VerifyPaymentMethod;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class CheckoutDomainsClientTest extends TestCase
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
        ListCheckoutDomains $operation,
        ResponseInterface $response,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->checkoutDomains->list($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            new ListCheckoutDomains(),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/checkout-domains', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Default Paged' => [
            new ListCheckoutDomains(new Pager()),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf(
                '%s/checkout-domains?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'ID Filtered' => [
            new ListCheckoutDomains(ids: ['chedom_01j2abc3def4ghi5jkl6mno7pq']),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/checkout-domains?id=chedom_01j2abc3def4ghi5jkl6mno7pq', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Domain Filtered' => [
            new ListCheckoutDomains(domain: 'app.example.com'),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/checkout-domains?domain=app.example.com', Environment::SANDBOX->baseUrl()),
        ];

        yield 'Status Filtered' => [
            new ListCheckoutDomains(statuses: [CheckoutDomainApprovalStatus::Approved()]),
            new Response(200, body: self::readRawJsonFixture('response/list_default')),
            sprintf('%s/checkout-domains?status=approved', Environment::SANDBOX->baseUrl()),
        ];
    }

    /** @test */
    public function get_hits_expected_uri(): void
    {
        $response = new Response(200, body: self::readRawJsonFixture('response/full_entity'));
        $this->mockClient->addResponse($response);
        $this->client->checkoutDomains->get('chedom_01j2abc3def4ghi5jkl6mno7pq');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            sprintf('%s/checkout-domains/chedom_01j2abc3def4ghi5jkl6mno7pq', Environment::SANDBOX->baseUrl()),
            urldecode((string) $request->getUri()),
        );
    }

    /** @test */
    public function delete_hits_expected_uri(): void
    {
        $this->mockClient->addResponse(new Response(204));
        $this->client->checkoutDomains->delete('chedom_01j2abc3def4ghi5jkl6mno7pq');
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('DELETE', $request->getMethod());
        self::assertEquals(
            sprintf('%s/checkout-domains/chedom_01j2abc3def4ghi5jkl6mno7pq', Environment::SANDBOX->baseUrl()),
            urldecode((string) $request->getUri()),
        );
    }

    /** @test */
    public function it_uses_expected_payload_on_verify_payment_method(): void
    {
        $this->mockClient->addResponse(
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
        );
        $this->client->checkoutDomains->verifyPaymentMethod(
            'chedom_01j2abc3def4ghi5jkl6mno7pq',
            new VerifyPaymentMethod(CheckoutDomainPaymentMethod::ApplePay()),
        );
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(
            sprintf('%s/checkout-domains/chedom_01j2abc3def4ghi5jkl6mno7pq/verify-payment-method', Environment::SANDBOX->baseUrl()),
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString(
            self::readRawJsonFixture('request/verify_payment_method'),
            (string) $request->getBody(),
        );
    }
}
