<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Transaction;

use Paddle\SDK\PaddleEnum;

/**
 * @method static TransactionCardType AmericanExpress()
 * @method static TransactionCardType DinersClub()
 * @method static TransactionCardType Discover()
 * @method static TransactionCardType Jcb()
 * @method static TransactionCardType Mada()
 * @method static TransactionCardType Maestro()
 * @method static TransactionCardType Mastercard()
 * @method static TransactionCardType UnionPay()
 * @method static TransactionCardType Unknown()
 * @method static TransactionCardType Visa()
 */
final class TransactionCardType extends PaddleEnum
{
    private const AmericanExpress = 'american_express';
    private const DinersClub = 'diners_club';
    private const Discover = 'discover';
    private const Jcb = 'jcb';
    private const Mada = 'mada';
    private const Maestro = 'maestro';
    private const Mastercard = 'mastercard';
    private const UnionPay = 'union_pay';
    private const Unknown = 'unknown';
    private const Visa = 'visa';
}
