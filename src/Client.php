<?php

declare(strict_types=1);

namespace Paddle\SDK;

use Http\Client\Common\Plugin\AuthenticationPlugin;
use Http\Client\Common\Plugin\ContentLengthPlugin;
use Http\Client\Common\Plugin\ContentTypePlugin;
use Http\Client\Common\Plugin\DecoderPlugin;
use Http\Client\Common\Plugin\HeaderSetPlugin;
use Http\Client\Common\Plugin\LoggerPlugin;
use Http\Client\Common\Plugin\ResponseSeekableBodyPlugin;
use Http\Client\Common\Plugin\RetryPlugin;
use Http\Client\Common\PluginClient;
use Http\Client\HttpAsyncClient;
use Http\Discovery\HttpAsyncClientDiscovery;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Message\Authentication\Bearer;
use Paddle\SDK\Logger\Formatter;
use Paddle\SDK\Resources\Addresses\AddressesClient;
use Paddle\SDK\Resources\Adjustments\AdjustmentsClient;
use Paddle\SDK\Resources\Businesses\BusinessesClient;
use Paddle\SDK\Resources\Customers\CustomersClient;
use Paddle\SDK\Resources\Discounts\DiscountsClient;
use Paddle\SDK\Resources\Events\EventsClient;
use Paddle\SDK\Resources\EventTypes\EventTypesClient;
use Paddle\SDK\Resources\NotificationLogs\NotificationLogsClient;
use Paddle\SDK\Resources\Notifications\NotificationsClient;
use Paddle\SDK\Resources\NotificationSettings\NotificationSettingsClient;
use Paddle\SDK\Resources\Prices\PricesClient;
use Paddle\SDK\Resources\PricingPreviews\PricingPreviewsClient;
use Paddle\SDK\Resources\Products\ProductsClient;
use Paddle\SDK\Resources\Reports\ReportsClient;
use Paddle\SDK\Resources\Subscriptions\SubscriptionsClient;
use Paddle\SDK\Resources\Transactions\TransactionsClient;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Psr\Http\Message\UriInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Uid\Ulid;

class Client
{
    private const SDK_VERSION = '1.1.0';

    public readonly LoggerInterface $logger;
    public readonly Options $options;

    public readonly ProductsClient $products;
    public readonly PricesClient $prices;
    public readonly TransactionsClient $transactions;
    public readonly AdjustmentsClient $adjustments;
    public readonly CustomersClient $customers;
    public readonly AddressesClient $addresses;
    public readonly BusinessesClient $businesses;
    public readonly DiscountsClient $discounts;
    public readonly SubscriptionsClient $subscriptions;
    public readonly EventTypesClient $eventTypes;
    public readonly EventsClient $events;
    public readonly PricingPreviewsClient $pricingPreviews;
    public readonly NotificationSettingsClient $notificationSettings;
    public readonly NotificationsClient $notifications;
    public readonly NotificationLogsClient $notificationLogs;
    public readonly ReportsClient $reports;

    private readonly HttpAsyncClient $httpClient;
    private readonly RequestFactoryInterface $requestFactory;
    private readonly StreamFactoryInterface $streamFactory;
    private readonly UriFactoryInterface $uriFactory;
    private string|null $transactionId = null;

    public function __construct(
        #[\SensitiveParameter] private readonly string $apiKey,
        Options|null $options = null,
        HttpAsyncClient|null $httpClient = null,
        LoggerInterface|null $logger = null,
        RequestFactoryInterface|null $requestFactory = null,
        StreamFactoryInterface|null $streamFactory = null,
        UriFactoryInterface|null $uriFactory = null,
    ) {
        $this->options = $options ?: new Options();
        $this->logger = $logger ?: new NullLogger();

        $this->requestFactory = $requestFactory ?: Psr17FactoryDiscovery::findRequestFactory();
        $this->streamFactory = $streamFactory ?: Psr17FactoryDiscovery::findStreamFactory();
        $this->uriFactory = $uriFactory ?: Psr17FactoryDiscovery::findUriFactory();

        $this->httpClient = $this->buildClient(
            $httpClient ?: HttpAsyncClientDiscovery::find(),
        );

        $this->products = new ProductsClient($this);
        $this->prices = new PricesClient($this);
        $this->transactions = new TransactionsClient($this);
        $this->adjustments = new AdjustmentsClient($this);
        $this->customers = new CustomersClient($this);
        $this->addresses = new AddressesClient($this);
        $this->businesses = new BusinessesClient($this);
        $this->discounts = new DiscountsClient($this);
        $this->subscriptions = new SubscriptionsClient($this);
        $this->eventTypes = new EventTypesClient($this);
        $this->events = new EventsClient($this);
        $this->pricingPreviews = new PricingPreviewsClient($this);
        $this->notificationSettings = new NotificationSettingsClient($this);
        $this->notifications = new NotificationsClient($this);
        $this->notificationLogs = new NotificationLogsClient($this);
        $this->reports = new ReportsClient($this);
    }

    public function getRaw(string|UriInterface $uri, array|HasParameters $parameters = []): ResponseInterface
    {
        if ($parameters) {
            $parameters = $parameters instanceof HasParameters ? $parameters->getParameters() : $parameters;
            $query = \http_build_query($parameters);

            if ($uri instanceof UriInterface) {
                $uri = $uri->withQuery($query);
            } else {
                $uri .= '?' . $query;
            }
        }

        return $this->requestRaw('GET', $uri);
    }

    public function patchRaw(string|UriInterface $uri, array|\JsonSerializable $payload): ResponseInterface
    {
        return $this->requestRaw('PATCH', $uri, $payload);
    }

    public function postRaw(string|UriInterface $uri, array|\JsonSerializable $payload = [], array|HasParameters $parameters = []): ResponseInterface
    {
        if ($parameters) {
            $parameters = $parameters instanceof HasParameters ? $parameters->getParameters() : $parameters;
            $query = \http_build_query($parameters);

            if ($uri instanceof UriInterface) {
                $uri = $uri->withQuery($query);
            } else {
                $uri .= '?' . $query;
            }
        }

        return $this->requestRaw('POST', $uri, $payload);
    }

    public function deleteRaw(string|UriInterface $uri): ResponseInterface
    {
        return $this->requestRaw('DELETE', $uri);
    }

    private function requestRaw(string $method, string|UriInterface $uri, array|\JsonSerializable|null $payload = null): ResponseInterface
    {
        if (\is_string($uri)) {
            $components = \parse_url($this->options->environment->baseUrl());

            $uri = $this->uriFactory->createUri($uri)
                ->withScheme($components['scheme'])
                ->withHost($components['host']);
        }

        $request = $this->requestFactory->createRequest($method, $uri);

        $serializer = new Serializer(
            [new BackedEnumNormalizer(), new JsonSerializableNormalizer(), new ObjectNormalizer(nameConverter: new CamelCaseToSnakeCaseNameConverter())],
            [new JsonEncoder()],
        );

        if ($payload !== null) {
            $body = $serializer->serialize($payload, 'json');

            $request = $request->withBody(
                // Satisfies empty body requests.
                $this->streamFactory->createStream($body === '[]' ? '{}' : $body),
            );
        }

        $request = $request->withAddedHeader('X-Transaction-ID', $this->transactionId ?? (string) new Ulid());

        return $this->httpClient->sendAsyncRequest($request)->wait();
    }

    private function buildClient(HttpAsyncClient $httpClient): PluginClient
    {
        return new PluginClient($httpClient, [
            new AuthenticationPlugin(new Bearer($this->apiKey)),
            new ContentTypePlugin(),
            new ContentLengthPlugin(),
            new DecoderPlugin(['use_content_encoding' => false]),
            new HeaderSetPlugin([
                'User-Agent' => 'PaddleSDK/php ' . self::SDK_VERSION,
            ]),
            new RetryPlugin([
                'retries' => $this->options->retries,
            ]),
            new LoggerPlugin($this->logger, new Formatter()),
            new ResponseSeekableBodyPlugin(),
        ]);
    }
}
