<?php

declare(strict_types=1);

namespace Paddle\SDK;

use Paddle\SDK\Entities\Shared\Pagination;
use Paddle\SDK\Exceptions\ApiError;
use Psr\Http\Message\ResponseInterface;

class ResponseParser
{
    private array|null $body = null;

    /**
     * @throws ApiError When the API response contains errors
     */
    public function __construct(ResponseInterface $response)
    {
        try {
            $this->body = json_decode(
                json: (string) $response->getBody(),
                associative: true,
                flags: JSON_THROW_ON_ERROR | JSON_PRESERVE_ZERO_FRACTION,
            );
        } catch (\JsonException) {
            $this->body = null;
        }

        $this->parseErrors();
    }

    public function getData(): array
    {
        return $this->body['data'] ?? [];
    }

    public function getPagination(): Pagination
    {
        return new Pagination(
            perPage: $this->body['meta']['pagination']['per_page'],
            next: $this->body['meta']['pagination']['next'],
            hasMore: $this->body['meta']['pagination']['has_more'],
            estimatedTotal: $this->body['meta']['pagination']['estimated_total'],
        );
    }

    /**
     * @throws ApiError When an API returns an error
     *
     * @see https://developer.paddle.com/api-reference/about/errors
     * @see https://developer.paddle.com/errors/overview
     */
    private function parseErrors(): self
    {
        if (! isset($this->body['error'])) {
            return $this;
        }

        /** @var class-string<ApiError> $exceptionClass */
        $exceptionClass = $this->findExceptionClassFromCode($this->body['error']['code'] ?? 'shared_error');

        throw $exceptionClass::fromErrorData($this->body['error']);
    }

    /**
     * @return class-string<ApiError>
     */
    private function findExceptionClassFromCode(string $code): string
    {
        $parts = explode('_', $code);
        $resource = ucfirst($parts[0] ?? '');

        if ($resource === '') {
            return ApiError::class;
        }

        $className = "Paddle\\SDK\\Exceptions\\ApiError\\{$resource}ApiError";

        if (! class_exists($className)) {
            return ApiError::class;
        }

        return $className;
    }
}
