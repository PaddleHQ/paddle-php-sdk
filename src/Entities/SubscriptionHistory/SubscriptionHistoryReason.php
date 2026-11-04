<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

use Paddle\SDK\PaddleEnum;

/**
 * @method static SubscriptionHistoryReason CardlessTrialEnded()
 * @method static SubscriptionHistoryReason ImportIssue()
 * @method static SubscriptionHistoryReason MissingConsent()
 * @method static SubscriptionHistoryReason SellerRequest()
 * @method static SubscriptionHistoryReason CustomerRequest()
 * @method static SubscriptionHistoryReason Chargeback()
 * @method static SubscriptionHistoryReason EuWithdrawal()
 */
final class SubscriptionHistoryReason extends PaddleEnum
{
    private const CardlessTrialEnded = 'cardless_trial_ended';
    private const ImportIssue = 'import_issue';
    private const MissingConsent = 'missing_consent';
    private const SellerRequest = 'seller_request';
    private const CustomerRequest = 'customer_request';
    private const Chargeback = 'chargeback';
    private const EuWithdrawal = 'eu_withdrawal';
}
