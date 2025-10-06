<?php

declare(strict_types=1);

namespace Paddle\SDK\Exceptions;

use Psr\Http\Client\ClientExceptionInterface;
use Psr\Http\Message\ResponseInterface;

class ApiError extends \Exception implements ClientExceptionInterface
{
    /** @var array<FieldError> */
    public array $fieldErrors;

    public readonly int|null $retryAfter;

    final public function __construct(
        public string $type,
        public string $errorCode,
        public string $detail,
        public string $docsUrl,
        FieldError ...$fieldErrors,
    ) {
        $this->fieldErrors = $fieldErrors;

        parent::__construct($this->detail);
    }

    public static function fromErrorData(array $error, ResponseInterface|null $response = null): static
    {
        $apiError = new static(
            $error['type'],
            $error['code'],
            $error['detail'],
            $error['documentation_url'],
            ...array_map(
                fn (array $fieldError): FieldError => new FieldError($fieldError['field'], $fieldError['message']),
                $error['errors'] ?? [],
            ),
        );

        $retryAfterHeader = $response?->getHeader('Retry-After')[0] ?? null;
        $apiError->retryAfter = $retryAfterHeader ? intval($retryAfterHeader) : null;

        return $apiError;
    }
}
