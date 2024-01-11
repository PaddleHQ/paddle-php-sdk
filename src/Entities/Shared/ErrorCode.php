<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

enum ErrorCode: string
{
    case AlreadyCanceled = 'already_canceled';
    case AlreadyRefunded = 'already_refunded';
    case AuthenticationFailed = 'authentication_failed';
    case BlockedCard = 'blocked_card';
    case Canceled = 'canceled';
    case Declined = 'declined';
    case ExpiredCard = 'expired_card';
    case Fraud = 'fraud';
    case InvalidAmount = 'invalid_amount';
    case InvalidPaymentDetails = 'invalid_payment_details';
    case IssuerUnavailable = 'issuer_unavailable';
    case NotEnoughBalance = 'not_enough_balance';
    case PspError = 'psp_error';
    case RedactedPaymentMethod = 'redacted_payment_method';
    case SystemError = 'system_error';
    case TransactionNotPermitted = 'transaction_not_permitted';
    case Unknown = 'unknown';
}
