<?php

declare(strict_types=1);

namespace Paddle\SDK\Notifications;

use Psr\Http\Message\RequestInterface;

final class Verifier
{
    public function __construct(
        private readonly int|null $maximumVariance = 5,
    ) {
    }

    public function verify(RequestInterface $request, Secret ...$secrets): bool
    {
        $signatureData = $request->getHeader(PaddleSignature::HEADER);
        if ($signatureData === []) {
            return false;
        }

        $signature = PaddleSignature::parse($signatureData[0]);

        if ($this->maximumVariance > 0 && \time() > $signature->timestamp + $this->maximumVariance) {
            return false;
        }

        $request->getBody()->rewind();

        return $signature->verify(
            (string) $request->getBody(),
            ...$secrets,
        );
    }
}
