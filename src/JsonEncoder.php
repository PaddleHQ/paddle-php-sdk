<?php

declare(strict_types=1);

namespace Paddle\SDK;

use Paddle\SDK\Entities\DateTime;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\BackedEnumNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

final class JsonEncoder
{
    private function __construct(private readonly SerializerInterface $serializer)
    {
    }

    public static function default(): self
    {
        return new self(
            new Serializer(
                [
                    new BackedEnumNormalizer(),
                    new DateTimeNormalizer([DateTimeNormalizer::FORMAT_KEY => DateTime::PADDLE_RFC3339]),
                    new JsonSerializableNormalizer(),
                    new ObjectNormalizer(nameConverter: new CamelCaseToSnakeCaseNameConverter()),
                ],
                [new \Symfony\Component\Serializer\Encoder\JsonEncoder()],
            ),
        );
    }

    public function encode(mixed $payload): string
    {
        return $this->serializer->serialize($payload, 'json', [
            AbstractObjectNormalizer::PRESERVE_EMPTY_OBJECTS => true,
        ]);
    }
}
