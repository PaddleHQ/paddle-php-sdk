<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

use Paddle\SDK\Entities\DateTime;

class TransactionPaymentAttempt
{
    /**
     * @deprecated $storedPaymentMethodId
     */
    private function __construct(
        public string $paymentAttemptId,
        public string $paymentMethodId,
        public string $storedPaymentMethodId,
        public string $amount,
        public PaymentAttemptStatus $status,
        public ErrorCode|null $errorCode,
        public MethodDetails $methodDetails,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface|null $capturedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            $data['payment_attempt_id'],
            $data['payment_method_id'],
            $data['stored_payment_method_id'],
            $data['amount'],
            PaymentAttemptStatus::from($data['status']),
            isset($data['error_code']) ? ErrorCode::from($data['error_code']) : null,
            MethodDetails::from($data['method_details']),
            DateTime::from($data['created_at']),
            isset($data['captured_at']) ? DateTime::from($data['captured_at']) : null,
        );
    }
}
