<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Metrics;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Collections\MetricEntityDefinitionCollection;
use Paddle\SDK\Entities\Metrics\MetricEntity;
use Paddle\SDK\Entities\Metrics\MetricEntityDefinition;
use Paddle\SDK\Entities\Metrics\MetricsAggregation;
use Paddle\SDK\Entities\Metrics\MetricsBucketInterval;
use Paddle\SDK\Entities\Metrics\MetricsExplore;
use Paddle\SDK\Entities\Metrics\MetricsFieldType;
use Paddle\SDK\Entities\Metrics\MetricsFilterOperator;
use Paddle\SDK\Entities\Metrics\MetricsSortDirection;
use Paddle\SDK\Entities\Shared\CurrencyCode;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Metrics\Operations\Explore\ExploreFilter;
use Paddle\SDK\Resources\Metrics\Operations\Explore\ExploreMeasure;
use Paddle\SDK\Resources\Metrics\Operations\Explore\ExploreOrderBy;
use Paddle\SDK\Resources\Metrics\Operations\ExploreMetrics;
use Paddle\SDK\Resources\Metrics\Operations\ListExploreEntities;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class MetricsExploreTest extends TestCase
{
    use ReadsFixtures;

    private const FIRST_CURSOR = 'eyJ2IjoxLCJxaWQiOiIwMWpuOHg0azJwN3E5ciIsIm9mZiI6NSwicWgiOiJzaGEyNTY6OWYyYzRkMWUiLCJleHAiOjE3ODU1Njc2MDB9';

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
     */
    public function list_explore_entities_hits_expected_uri_and_parses_entities(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/explore_entities')));

        $entities = $this->client->metrics->listExploreEntities();
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/metrics/explore/entities', urldecode((string) $request->getUri()));
        self::assertInstanceOf(MetricEntityDefinitionCollection::class, $entities);

        $all = iterator_to_array($entities);
        self::assertCount(1, $all);

        $entity = $all[0];
        self::assertInstanceOf(MetricEntityDefinition::class, $entity);
        self::assertEquals(MetricEntity::Subscriptions(), $entity->entity);
        self::assertEquals([MetricsBucketInterval::Month()], $entity->timeDimension->intervals);
        self::assertSame(1096, $entity->timeDimension->maxLookbackDays);
        self::assertSame(
            ['product', 'country', 'billing_cycle', 'subscription_activity'],
            array_map(fn ($dimension) => $dimension->name, $entity->dimensions),
        );
        self::assertEquals(MetricsFieldType::String(), $entity->dimensions[0]->type);
        self::assertEquals([MetricsFilterOperator::In()], $entity->dimensions[0]->filterOps);
        self::assertFalse($entity->dimensions[0]->multiValued);
        self::assertSame('mrr', $entity->measures[0]->name);
        self::assertEquals(MetricsFieldType::Currency(), $entity->measures[0]->type);
        self::assertNull($entity->measures[0]->aggs);
    }

    /**
     * @test
     */
    public function list_explore_entities_filters_by_entity(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/explore_entities')));

        $this->client->metrics->listExploreEntities(new ListExploreEntities(MetricEntity::Subscriptions()));
        $request = $this->mockClient->getLastRequest();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/metrics/explore/entities?entity=subscriptions',
            urldecode((string) $request->getUri()),
        );
    }

    /**
     * @test
     */
    public function list_explore_entities_parses_measure_aggregations(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/explore_entities_with_aggs')));

        $entity = iterator_to_array($this->client->metrics->listExploreEntities())[0];

        self::assertEquals([MetricsAggregation::Sum(), MetricsAggregation::Count()], $entity->measures[0]->aggs);
        self::assertEquals([MetricsBucketInterval::Day(), MetricsBucketInterval::Week()], $entity->timeDimension->intervals);
        self::assertSame([], $entity->dimensions);
    }

    /**
     * @test
     */
    public function explore_sends_full_body_and_parses_response(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/explore')));

        $response = $this->client->metrics->explore(new ExploreMetrics(
            entity: MetricEntity::TransactionsCompleted(),
            from: new \DateTimeImmutable('2026-05-01T00:00:00Z'),
            to: '2026-08-01',
            measures: [
                new ExploreMeasure('gross_revenue', MetricsAggregation::Sum()),
                new ExploreMeasure('count'),
            ],
            interval: MetricsBucketInterval::Month(),
            dimensions: ['product'],
            filters: [new ExploreFilter('country', MetricsFilterOperator::In(), ['US', 'GB'])],
            orderBy: [new ExploreOrderBy('gross_revenue', MetricsSortDirection::Desc())],
            perPage: 5,
        ));

        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('POST', $request->getMethod());
        self::assertEquals(Environment::SANDBOX->baseUrl() . '/metrics/explore', urldecode((string) $request->getUri()));
        self::assertJsonStringEqualsJsonString(
            json_encode([
                'entity' => 'transactions.completed',
                'from' => '2026-05-01T00:00:00.000000Z',
                'to' => '2026-08-01',
                'measures' => [['field' => 'gross_revenue', 'agg' => 'sum'], ['field' => 'count']],
                'interval' => 'month',
                'dimensions' => ['product'],
                'filters' => [['field' => 'country', 'op' => 'in', 'value' => ['US', 'GB']]],
                'order_by' => [['field' => 'gross_revenue', 'dir' => 'desc']],
                'per_page' => 5,
            ]),
            (string) $request->getBody(),
        );

        self::assertInstanceOf(MetricsExplore::class, $response);

        $data = $response;
        self::assertEquals(MetricEntity::TransactionsCompleted(), $data->entity);
        self::assertEquals(MetricsBucketInterval::Month(), $data->interval);
        self::assertEquals(CurrencyCode::USD(), $data->currencyCode);
        self::assertSame('2026-05-01T00:00:00.000000Z', $data->startsAt->format('Y-m-d\TH:i:s.up'));
        self::assertSame('2026-08-01T00:00:00.000000Z', $data->endsAt->format('Y-m-d\TH:i:s.up'));
        self::assertSame('2026-08-01T03:00:00.000000Z', $data->updatedAt->format('Y-m-d\TH:i:s.up'));
        self::assertSame('product', $data->fields->dimensions[0]->name);
        self::assertEquals(MetricsFieldType::String(), $data->fields->dimensions[0]->type);
        self::assertSame('sum_gross_revenue', $data->fields->measures[0]->name);
        self::assertEquals(MetricsFieldType::Currency(), $data->fields->measures[0]->type);
        self::assertSame('gross_revenue', $data->fields->measures[0]->field);
        self::assertEquals(MetricsAggregation::Sum(), $data->fields->measures[0]->agg);
        self::assertCount(1, $data->series);
        self::assertSame(['product' => 'pro_01h1vjfevh5etwq3rb416a23h2'], $data->series[0]->dimensions);
        self::assertSame(
            ['2026-05-01', '2026-06-01', '2026-07-01'],
            array_map(fn ($point) => $point->timestamp, $data->series[0]->timeseries),
        );
        self::assertSame(['sum_gross_revenue' => '142000'], $data->series[0]->timeseries[2]->measures);

        self::assertSame(5, $response->pagination->perPage);
        self::assertTrue($response->pagination->hasMore);
        self::assertSame(42, $response->pagination->estimatedTotal);
        self::assertSame('https://api.paddle.com/metrics/explore?after=' . self::FIRST_CURSOR, $response->pagination->next);
        self::assertTrue($response->pagination->hasMore);
        self::assertSame(self::FIRST_CURSOR, $response->pagination->after);
    }

    /**
     * @test
     */
    public function explore_minimal_body_omits_optional_fields(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/explore')));

        $this->client->metrics->explore(new ExploreMetrics(
            entity: MetricEntity::Checkouts(),
            from: '2026-05-01',
            to: '2026-08-01',
            measures: [new ExploreMeasure('count')],
        ));

        self::assertJsonStringEqualsJsonString(
            json_encode([
                'entity' => 'checkouts',
                'from' => '2026-05-01',
                'to' => '2026-08-01',
                'measures' => [['field' => 'count']],
            ]),
            (string) $this->mockClient->getLastRequest()->getBody(),
        );
    }

    /**
     * @test
     */
    public function explore_sends_null_aggregation(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/explore')));

        $this->client->metrics->explore(new ExploreMetrics(
            entity: MetricEntity::Subscriptions(),
            from: '2026-05-01',
            to: '2026-08-01',
            measures: [new ExploreMeasure('mrr', null)],
        ));

        self::assertJsonStringEqualsJsonString(
            json_encode([
                'entity' => 'subscriptions',
                'from' => '2026-05-01',
                'to' => '2026-08-01',
                'measures' => [['field' => 'mrr', 'agg' => null]],
            ]),
            (string) $this->mockClient->getLastRequest()->getBody(),
        );
    }

    /**
     * @test
     */
    public function explore_leaves_out_empty_after(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/explore')));

        $this->client->metrics->explore(
            new ExploreMetrics(
                entity: MetricEntity::TransactionsCompleted(),
                from: '2026-05-01',
                to: '2026-08-01',
                measures: [new ExploreMeasure('gross_revenue', MetricsAggregation::Sum())],
            ),
            after: '',
        );

        self::assertSame(
            Environment::SANDBOX->baseUrl() . '/metrics/explore',
            urldecode((string) $this->mockClient->getLastRequest()->getUri()),
        );
    }

    /**
     * @test
     */
    public function explore_follows_next_cursor(): void
    {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/explore')));
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture('response/explore_last_page')));

        $operation = new ExploreMetrics(
            entity: MetricEntity::TransactionsCompleted(),
            from: '2026-05-01',
            to: '2026-08-01',
            measures: [new ExploreMeasure('gross_revenue', MetricsAggregation::Sum())],
            dimensions: ['product'],
        );

        $first = $this->client->metrics->explore($operation);
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/metrics/explore',
            urldecode((string) $this->mockClient->getLastRequest()->getUri()),
        );

        $second = $this->client->metrics->explore($operation, after: $first->pagination->after);
        $request = $this->mockClient->getLastRequest();

        self::assertEquals(
            Environment::SANDBOX->baseUrl() . '/metrics/explore?after=' . self::FIRST_CURSOR,
            urldecode((string) $request->getUri()),
        );
        self::assertSame(['product'], json_decode((string) $request->getBody(), true)['dimensions']);
        self::assertSame(['product' => 'pro_01h1vjfevh5etwq3rb416a23h3'], $second->series[0]->dimensions);
        self::assertFalse($second->pagination->hasMore);
        self::assertNull($second->pagination->after);
    }
}
