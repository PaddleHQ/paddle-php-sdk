<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities;

use Paddle\SDK\Entities\CheckoutDomain\CheckoutDomainApprovalStatus;
use Paddle\SDK\Entities\CheckoutDomain\CheckoutDomainPaymentMethodVerification;

class CheckoutDomain implements Entity
{
    private function __construct(
        public string $id,
        public string $domain,
        public CheckoutDomainApprovalStatus $status,
        public CheckoutDomainPaymentMethodVerification $paymentMethodVerification,
        public \DateTimeInterface $createdAt,
        public \DateTimeInterface $updatedAt,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            id: $data['id'],
            domain: $data['domain'],
            status: CheckoutDomainApprovalStatus::from($data['status']),
            paymentMethodVerification: CheckoutDomainPaymentMethodVerification::from($data['payment_method_verification']),
            createdAt: DateTime::from($data['created_at']),
            updatedAt: DateTime::from($data['updated_at']),
        );
    }
}
