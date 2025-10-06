<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Unit;

use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\ResponseParser;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class ResponseParserTest extends TestCase
{
    /** @test */
    public function it_throws_api_error(): void
    {
        $responseBody = json_encode([
            'error' => [
                'type' => 'request_error',
                'code' => 'conflict',
                'detail' => 'Request conflicts with another change.',
                'documentation_url' => 'https://developer.paddle.com/errors/shared/conflict',
                'errors' => [],
            ],
        ]);

        /** @var ResponseInterface $response */
        $response = $this->createMock(ResponseInterface::class);
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($responseBody);
        $response->method('getBody')->willReturn($stream);
        $response->method('getStatusCode')->willReturn(409);
        $response->method('getHeader')->with('Retry-After')->willReturn([]);

        $this->expectException(ApiError::class);

        try {
            new ResponseParser($response);
        } catch (ApiError $e) {
            self::assertSame('conflict', $e->errorCode);
            self::assertNull($e->retryAfter);
            throw $e; // rethrow to satisfy expectException
        }
    }

    /** @test */
    public function it_throws_api_error_with_retry_after_for_too_many_requests(): void
    {
        $responseBody = json_encode([
            'error' => [
                'type' => 'request_error',
                'code' => 'too_many_requests',
                'detail' => 'IP address exceeded the allowed rate limit. Retry after the number of seconds in the Retry-After header.',
                'documentation_url' => 'https://developer.paddle.com/errors/shared/too_many_requests',
                'errors' => [],
            ],
        ]);

        /** @var ResponseInterface $response */
        $response = $this->createMock(ResponseInterface::class);
        $stream = $this->createMock(StreamInterface::class);
        $stream->method('__toString')->willReturn($responseBody);
        $response->method('getBody')->willReturn($stream);
        $response->method('getStatusCode')->willReturn(429);
        $response->method('getHeader')->with('Retry-After')->willReturn(['42']);

        $this->expectException(ApiError::class);

        try {
            new ResponseParser($response);
        } catch (ApiError $e) {
            self::assertSame('too_many_requests', $e->errorCode);
            self::assertSame(42, $e->retryAfter);
            throw $e; // rethrow to satisfy expectException
        }
    }
}
