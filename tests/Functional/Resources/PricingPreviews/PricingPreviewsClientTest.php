<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Prices;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\PricingPreview\PricePreviewItem;
use Paddle\SDK\Entities\Shared\AddressPreview;
use Paddle\SDK\Entities\Shared\CountryCode;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\PricingPreviews\Operations\PreviewPricesOperation;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class PricingPreviewsClientTest extends TestCase
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
    public function it_uses_expected_payload_on_preview_prices(
        PreviewPricesOperation $operation,
        ResponseInterface $response,
        string $expectedBody,
    ): void {
        $this->mockClient->addResponse($response);
        $this->client->pricingPreviews->previewPrices($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/pricing-preview', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
    }

    public static function createOperationsProvider(): \Generator
    {
        yield 'Minimal' => [
            new PreviewPricesOperation(
                [
                    new PricePreviewItem('pri_01gsz8z1q1n00f12qt82y31smh', 20),
                ],
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/preview_prices_minimal'),
        ];

        yield 'Multiple' => [
            new PreviewPricesOperation(
                [
                    new PricePreviewItem('pri_01gsz8z1q1n00f12qt82y31smh', 20),
                    new PricePreviewItem('pri_01gsz98e27ak2tyhexptwc58yk', 1),
                ],
                currencyCode: CurrencyCode::USD,
                discountId: 'dsc_01gtgztp8fpchantd5g1wrksa3',
                customerIpAddress: '34.232.58.13',
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/preview_prices_multiple'),
        ];

        yield 'Full' => [
            new PreviewPricesOperation(
                [
                    new PricePreviewItem('pri_01gsz8z1q1n00f12qt82y31smh', 20),
                    new PricePreviewItem('pri_01gsz98e27ak2tyhexptwc58yk', 1),
                ],
                customerId: 'ctm_01h25m0sar5845yv5j8zj5xwe1',
                addressId: 'add_01h848pep46enq8y372x7maj0p',
                businessId: 'biz_01hfvpm3fj1my86qqs1c32mzsp',
                currencyCode: CurrencyCode::USD,
                discountId: 'dsc_01gtgztp8fpchantd5g1wrksa3',
                address: new AddressPreview('20149', CountryCode::US),
                customerIpAddress: '34.232.58.13',
            ),
            new Response(200, body: self::readRawJsonFixture('response/full_entity')),
            self::readRawJsonFixture('request/preview_prices_full'),
        ];
    }
}
