<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\PaymentMethods;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Shared\KoreaLocalPaymentMethodType;
use Paddle\SDK\Entities\Shared\SavedPaymentMethodOrigin;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\PaymentMethods\Operations\ListPaymentMethods;
use Paddle\SDK\Resources\Shared\Operations\List\OrderBy;
use Paddle\SDK\Resources\Shared\Operations\List\Pager;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class PaymentMethodsClientTest extends TestCase
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
        string $customerId,
        ListPaymentMethods $listOperation,
        string $expectedUri,
    ): void {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_default')));
        $this->client->paymentMethods->list($customerId, $listOperation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }

    public static function listOperationsProvider(): \Generator
    {
        yield 'Default' => [
            'ctm_01hv6y1jedq4p1n0yqn5ba3ky4',
            new ListPaymentMethods(),
            sprintf('%s/customers/ctm_01hv6y1jedq4p1n0yqn5ba3ky4/payment-methods', Environment::SANDBOX->baseUrl()),
        ];

        yield 'List by address IDs' => [
            'ctm_01hv6y1jedq4p1n0yqn5ba3ky4',
            new ListPaymentMethods(
                addressIds: ['add_01hv8h6jj90jjz0d71m6hj4r9z', 'add_02hv8h6jj90jjz0d71m6hj4r9z'],
            ),
            sprintf(
                '%s/customers/ctm_01hv6y1jedq4p1n0yqn5ba3ky4/payment-methods?address_id=add_01hv8h6jj90jjz0d71m6hj4r9z,add_02hv8h6jj90jjz0d71m6hj4r9z',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'List supports_checkout false' => [
            'ctm_01hv6y1jedq4p1n0yqn5ba3ky4',
            new ListPaymentMethods(
                supportsCheckout: false,
            ),
            sprintf('%s/customers/ctm_01hv6y1jedq4p1n0yqn5ba3ky4/payment-methods?supports_checkout=false', Environment::SANDBOX->baseUrl()),
        ];

        yield 'List supports_checkout true' => [
            'ctm_01hv6y1jedq4p1n0yqn5ba3ky4',
            new ListPaymentMethods(
                supportsCheckout: true,
            ),
            sprintf('%s/customers/ctm_01hv6y1jedq4p1n0yqn5ba3ky4/payment-methods?supports_checkout=true', Environment::SANDBOX->baseUrl()),
        ];

        yield 'List by address IDs and supports_checkout' => [
            'ctm_01hv6y1jedq4p1n0yqn5ba3ky4',
            new ListPaymentMethods(
                addressIds: ['add_01hv8h6jj90jjz0d71m6hj4r9z', 'add_02hv8h6jj90jjz0d71m6hj4r9z'],
                supportsCheckout: true,
            ),
            sprintf(
                '%s/customers/ctm_01hv6y1jedq4p1n0yqn5ba3ky4/payment-methods?address_id=add_01hv8h6jj90jjz0d71m6hj4r9z,add_02hv8h6jj90jjz0d71m6hj4r9z&supports_checkout=true',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'List payment-methods with pagination' => [
            'ctm_01hv6y1jedq4p1n0yqn5ba3ky4',
            new ListPaymentMethods(
                pager: new Pager(),
            ),
            sprintf(
                '%s/customers/ctm_01hv6y1jedq4p1n0yqn5ba3ky4/payment-methods?order_by=id[asc]&per_page=50',
                Environment::SANDBOX->baseUrl(),
            ),
        ];

        yield 'List payment-methods with pagination after' => [
            'ctm_01hv6y1jedq4p1n0yqn5ba3ky4',
            new ListPaymentMethods(
                pager: new Pager(
                    after: 'paymtd_01hs8zx6x377xfsfrt2bqsevbw',
                    orderBy: OrderBy::idDescending(),
                    perPage: 100,
                ),
            ),
            sprintf(
                '%s/customers/ctm_01hv6y1jedq4p1n0yqn5ba3ky4/payment-methods?after=paymtd_01hs8zx6x377xfsfrt2bqsevbw&order_by=id[desc]&per_page=100',
                Environment::SANDBOX->baseUrl(),
            ),
        ];
    }

    /** @test */
    public function it_can_paginate(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_paginated_page_one')));
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/list_paginated_page_two')));

        $collection = $this->client->paymentMethods->list('ctm_01hv6y1jedq4p1n0yqn5ba3ky4');

        $request = $this->mockClient->getLastRequest();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/customers/ctm_01hv6y1jedq4p1n0yqn5ba3ky4/payment-methods',
            urldecode((string) $request->getUri()),
        );

        $allPaymentMethods = iterator_to_array($collection);
        self::assertCount(4, $allPaymentMethods);

        $request = $this->mockClient->getLastRequest();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/customers/ctm_01hv6y1jedq4p1n0yqn5ba3ky4/payment-methods?after=paymtd_02hs8zx6x377xfsfrt2bqsevbw',
            urldecode((string) $request->getUri()),
        );
    }

    /**
     * @test
     */
    public function get_payment_methods_returns_expected_card_response(): void
    {
        $customerId = 'ctm_01hv6y1jedq4p1n0yqn5ba3ky4';
        $paymentMethodId = 'paymtd_01hs8zx6x377xfsfrt2bqsevbw';
        $expectedUri = sprintf(
            '%s/customers/%s/payment-methods/%s',
            Environment::SANDBOX->baseUrl(),
            $customerId,
            $paymentMethodId,
        );
        $response = new Response(200, body: self::readRawJsonFixture('response/full_entity_card'));

        $this->mockClient->addResponse($response);
        $paymentMethod = $this->client->paymentMethods->get($customerId, $paymentMethodId);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));

        self::assertSame($paymentMethodId, $paymentMethod->id);
        self::assertSame($customerId, $paymentMethod->customerId);
        self::assertSame('add_01hv8h6jj90jjz0d71m6hj4r9z', $paymentMethod->addressId);
        self::assertNull($paymentMethod->paypal);
        self::assertEquals(SavedPaymentMethodOrigin::Subscription(), $paymentMethod->origin);
        self::assertSame('2024-05-03T11:50:23.422+00:00', $paymentMethod->savedAt->format(DATE_RFC3339_EXTENDED));
        self::assertSame('2024-05-04T11:50:23.422+00:00', $paymentMethod->updatedAt->format(DATE_RFC3339_EXTENDED));

        $card = $paymentMethod->card;
        self::assertEquals('visa', $card->type);
        self::assertEquals('0002', $card->last4);
        self::assertEquals(1, $card->expiryMonth);
        self::assertEquals(2025, $card->expiryYear);
        self::assertEquals('Sam Miller', $card->cardholderName);
    }

    /**
     * @test
     */
    public function get_payment_methods_returns_expected_paypal_response(): void
    {
        $customerId = 'ctm_01hv6y1jedq4p1n0yqn5ba3ky4';
        $paymentMethodId = 'paymtd_01hs8zx6x377xfsfrt2bqsevbw';
        $expectedUri = sprintf(
            '%s/customers/%s/payment-methods/%s',
            Environment::SANDBOX->baseUrl(),
            $customerId,
            $paymentMethodId,
        );
        $response = new Response(200, body: self::readRawJsonFixture('response/full_entity_paypal'));

        $this->mockClient->addResponse($response);
        $paymentMethod = $this->client->paymentMethods->get($customerId, $paymentMethodId);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));

        self::assertSame($paymentMethodId, $paymentMethod->id);
        self::assertSame($customerId, $paymentMethod->customerId);
        self::assertSame('add_01hv8h6jj90jjz0d71m6hj4r9z', $paymentMethod->addressId);
        self::assertNull($paymentMethod->card);
        self::assertEquals(SavedPaymentMethodOrigin::SavedDuringPurchase(), $paymentMethod->origin);
        self::assertSame('2024-05-03T11:50:23.422+00:00', $paymentMethod->savedAt->format(DATE_RFC3339_EXTENDED));
        self::assertSame('2024-05-04T11:50:23.422+00:00', $paymentMethod->updatedAt->format(DATE_RFC3339_EXTENDED));

        $paypal = $paymentMethod->paypal;
        self::assertEquals('sam@example.com', $paypal->email);
        self::assertEquals('some-reference', $paypal->reference);
    }

    /**
     * @test
     */
    public function get_payment_methods_returns_expected_korea_local_response(): void
    {
        $customerId = 'ctm_01hv6y1jedq4p1n0yqn5ba3ky4';
        $paymentMethodId = 'paymtd_01hs8zx6x377xfsfrt2bqsevbw';
        $expectedUri = sprintf(
            '%s/customers/%s/payment-methods/%s',
            Environment::SANDBOX->baseUrl(),
            $customerId,
            $paymentMethodId,
        );
        $response = new Response(200, body: self::readRawJsonFixture('response/full_entity_korea_local'));

        $this->mockClient->addResponse($response);
        $paymentMethod = $this->client->paymentMethods->get($customerId, $paymentMethodId);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));

        self::assertSame($paymentMethodId, $paymentMethod->id);
        self::assertSame($customerId, $paymentMethod->customerId);
        self::assertSame('add_01hv8h6jj90jjz0d71m6hj4r9z', $paymentMethod->addressId);
        self::assertNull($paymentMethod->card);
        self::assertNull($paymentMethod->paypal);
        self::assertEquals(SavedPaymentMethodOrigin::Subscription(), $paymentMethod->origin);
        self::assertSame('2024-05-03T11:50:23.422+00:00', $paymentMethod->savedAt->format(DATE_RFC3339_EXTENDED));
        self::assertSame('2024-05-04T11:50:23.422+00:00', $paymentMethod->updatedAt->format(DATE_RFC3339_EXTENDED));

        $koreaLocal = $paymentMethod->underlyingDetails->koreaLocal;
        self::assertEquals(KoreaLocalPaymentMethodType::KakaoBank(), $koreaLocal->type);
    }

    /** @test */
    public function delete_hits_expected_uri(): void
    {
        $customerId = 'ctm_01hv6y1jedq4p1n0yqn5ba3ky4';
        $paymentMethodId = 'paymtd_01hs8zx6x377xfsfrt2bqsevbw';
        $expectedUri = sprintf(
            '%s/customers/%s/payment-methods/%s',
            Environment::SANDBOX->baseUrl(),
            $customerId,
            $paymentMethodId,
        );

        $this->mockClient->addResponse(new Response(204));
        $this->client->paymentMethods->delete($customerId, $paymentMethodId);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('DELETE', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
    }
}
