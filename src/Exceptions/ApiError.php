<?php

declare(strict_types=1);

namespace Paddle\SDK\Exceptions;

use Psr\Http\Client\ClientExceptionInterface;

class ApiError extends \Exception implements ClientExceptionInterface
{
    /** @var array<FieldError> */
    public array $fieldErrors;

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

    public static function fromErrorData(array $error): static
    {
        return new static(
            $error['type'],
            $error['code'],
            $error['detail'],
            $error['documentation_url'],
            ...array_map(
                fn (array $fieldError): FieldError => new FieldError($fieldError['field'], $fieldError['message']),
                $error['errors'] ?? [],
            ),
        );
    }
}
