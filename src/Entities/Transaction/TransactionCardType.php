<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Transaction;

enum TransactionCardType: string
{
    case AmericanExpress = 'american_express';
    case DinersClub = 'diners_club';
    case Discover = 'discover';
    case Jcb = 'jcb';
    case Mada = 'mada';
    case Maestro = 'maestro';
    case Mastercard = 'mastercard';
    case UnionPay = 'union_pay';
    case Unknown = 'unknown';
    case Visa = 'visa';
}
