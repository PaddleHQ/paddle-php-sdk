<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Notifications\Entities\Shared;

use Paddle\SDK\PaddleEnum;

/**
 * @method static ErrorCode AlreadyCanceled()
 * @method static ErrorCode AlreadyRefunded()
 * @method static ErrorCode AuthenticationFailed()
 * @method static ErrorCode BlockedCard()
 * @method static ErrorCode Canceled()
 * @method static ErrorCode Declined()
 * @method static ErrorCode ExpiredCard()
 * @method static ErrorCode Fraud()
 * @method static ErrorCode InvalidAmount()
 * @method static ErrorCode InvalidPaymentDetails()
 * @method static ErrorCode IssuerUnavailable()
 * @method static ErrorCode NotEnoughBalance()
 * @method static ErrorCode PspError()
 * @method static ErrorCode RedactedPaymentMethod()
 * @method static ErrorCode SystemError()
 * @method static ErrorCode TransactionNotPermitted()
 * @method static ErrorCode Unknown()
 */
final class ErrorCode extends PaddleEnum
{
    private const AlreadyCanceled = 'already_canceled';
    private const AlreadyRefunded = 'already_refunded';
    private const AuthenticationFailed = 'authentication_failed';
    private const BlockedCard = 'blocked_card';
    private const Canceled = 'canceled';
    private const Declined = 'declined';
    private const ExpiredCard = 'expired_card';
    private const Fraud = 'fraud';
    private const InvalidAmount = 'invalid_amount';
    private const InvalidPaymentDetails = 'invalid_payment_details';
    private const IssuerUnavailable = 'issuer_unavailable';
    private const NotEnoughBalance = 'not_enough_balance';
    private const PspError = 'psp_error';
    private const RedactedPaymentMethod = 'redacted_payment_method';
    private const SystemError = 'system_error';
    private const TransactionNotPermitted = 'transaction_not_permitted';
    private const Unknown = 'unknown';
}
