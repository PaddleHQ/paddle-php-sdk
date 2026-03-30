<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Metrics;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Metrics\MetricsActiveSubscribers;
use Paddle\SDK\Entities\Metrics\MetricsChargebacks;
use Paddle\SDK\Entities\Metrics\MetricsCheckoutConversion;
use Paddle\SDK\Entities\Metrics\MetricsMonthlyRecurringRevenue;
use Paddle\SDK\Entities\Metrics\MetricsMonthlyRecurringRevenueChange;
use Paddle\SDK\Entities\Metrics\MetricsRefunds;
use Paddle\SDK\Entities\Metrics\MetricsRevenue;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Metrics\Operations\GetMetrics;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class MetricsClientTest extends TestCase
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
            httpClient: $this->mockClient,
        );
    }

    /**
     * @test
     *
     * @dataProvider metricsOperationsProvider
     */
    public function it_hits_expected_uri_for_metrics(
        string $method,
        string $fixture,
        string $expectedPath,
        string $expectedEntityClass,
    ): void {
        $expectedUri = sprintf(
            '%s%s?from=2025-09-01&to=2025-09-05',
            Environment::SANDBOX->baseUrl(),
            $expectedPath,
        );

        $this->mockClient->addResponse(
            new Response(200, body: self::readRawJsonFixture($fixture)),
        );

        $operation = new GetMetrics(from: '2025-09-01', to: '2025-09-05');
        $result = $this->client->metrics->{$method}($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals($expectedUri, urldecode((string) $request->getUri()));
        self::assertInstanceOf($expectedEntityClass, $result);
    }

    public static function metricsOperationsProvider(): \Generator
    {
        yield 'Get monthly recurring revenue' => [
            'getMonthlyRecurringRevenue',
            'response/monthly_recurring_revenue',
            '/metrics/monthly-recurring-revenue',
            MetricsMonthlyRecurringRevenue::class,
        ];

        yield 'Get monthly recurring revenue change' => [
            'getMonthlyRecurringRevenueChange',
            'response/monthly_recurring_revenue_change',
            '/metrics/monthly-recurring-revenue-change',
            MetricsMonthlyRecurringRevenueChange::class,
        ];

        yield 'Get active subscribers' => [
            'getActiveSubscribers',
            'response/active_subscribers',
            '/metrics/active-subscribers',
            MetricsActiveSubscribers::class,
        ];

        yield 'Get revenue' => [
            'getRevenue',
            'response/revenue',
            '/metrics/revenue',
            MetricsRevenue::class,
        ];

        yield 'Get refunds' => [
            'getRefunds',
            'response/refunds',
            '/metrics/refunds',
            MetricsRefunds::class,
        ];

        yield 'Get chargebacks' => [
            'getChargebacks',
            'response/chargebacks',
            '/metrics/chargebacks',
            MetricsChargebacks::class,
        ];

        yield 'Get checkout conversion' => [
            'getCheckoutConversion',
            'response/checkout_conversion',
            '/metrics/checkout-conversion',
            MetricsCheckoutConversion::class,
        ];
    }
}
