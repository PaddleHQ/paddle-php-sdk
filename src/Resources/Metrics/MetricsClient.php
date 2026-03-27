<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\Metrics;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\Metrics\MetricsActiveSubscribers;
use Paddle\SDK\Entities\Metrics\MetricsChargebacks;
use Paddle\SDK\Entities\Metrics\MetricsCheckoutConversion;
use Paddle\SDK\Entities\Metrics\MetricsMonthlyRecurringRevenue;
use Paddle\SDK\Entities\Metrics\MetricsMonthlyRecurringRevenueChange;
use Paddle\SDK\Entities\Metrics\MetricsRefunds;
use Paddle\SDK\Entities\Metrics\MetricsRevenue;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Metrics\Operations\GetMetrics;
use Paddle\SDK\ResponseParser;

class MetricsClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getMonthlyRecurringRevenue(GetMetrics $operation): MetricsMonthlyRecurringRevenue
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/metrics/monthly-recurring-revenue', $operation),
        );

        return MetricsMonthlyRecurringRevenue::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getMonthlyRecurringRevenueChange(GetMetrics $operation): MetricsMonthlyRecurringRevenueChange
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/metrics/monthly-recurring-revenue-change', $operation),
        );

        return MetricsMonthlyRecurringRevenueChange::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getActiveSubscribers(GetMetrics $operation): MetricsActiveSubscribers
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/metrics/active-subscribers', $operation),
        );

        return MetricsActiveSubscribers::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getRevenue(GetMetrics $operation): MetricsRevenue
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/metrics/revenue', $operation),
        );

        return MetricsRevenue::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getRefunds(GetMetrics $operation): MetricsRefunds
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/metrics/refunds', $operation),
        );

        return MetricsRefunds::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getChargebacks(GetMetrics $operation): MetricsChargebacks
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/metrics/chargebacks', $operation),
        );

        return MetricsChargebacks::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getCheckoutConversion(GetMetrics $operation): MetricsCheckoutConversion
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/metrics/checkout-conversion', $operation),
        );

        return MetricsCheckoutConversion::from($parser->getData());
    }
}
