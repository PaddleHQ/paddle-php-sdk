<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\SubscriptionHistory;

final class SubscriptionHistoryDetailFactory
{
    /**
     * @var array<string, class-string<SubscriptionHistoryDetail>>
     */
    private const DETAILS = [
        'subscription_activated' => SubscriptionHistoryDetailSubscriptionActivated::class,
        'subscription_address_updated' => SubscriptionHistoryDetailSubscriptionAddressUpdated::class,
        'subscription_billing_cycle_updated' => SubscriptionHistoryDetailSubscriptionBillingCycleUpdated::class,
        'subscription_billing_date_updated' => SubscriptionHistoryDetailSubscriptionBillingDateUpdated::class,
        'subscription_billing_details_updated' => SubscriptionHistoryDetailSubscriptionBillingDetailsUpdated::class,
        'subscription_business_added' => SubscriptionHistoryDetailSubscriptionBusinessAdded::class,
        'subscription_business_removed' => SubscriptionHistoryDetailSubscriptionBusinessRemoved::class,
        'subscription_business_updated' => SubscriptionHistoryDetailSubscriptionBusinessUpdated::class,
        'subscription_canceled' => SubscriptionHistoryDetailSubscriptionCanceled::class,
        'subscription_collection_mode_updated' => SubscriptionHistoryDetailSubscriptionCollectionModeUpdated::class,
        'subscription_consent_requirement_granted' => SubscriptionHistoryDetailSubscriptionConsentRequirementGranted::class,
        'subscription_created' => SubscriptionHistoryDetailSubscriptionCreated::class,
        'subscription_currency_updated' => SubscriptionHistoryDetailSubscriptionCurrencyUpdated::class,
        'subscription_custom_data_updated' => SubscriptionHistoryDetailSubscriptionCustomDataUpdated::class,
        'subscription_customer_updated' => SubscriptionHistoryDetailSubscriptionCustomerUpdated::class,
        'subscription_discount_added' => SubscriptionHistoryDetailSubscriptionDiscountAdded::class,
        'subscription_discount_expired' => SubscriptionHistoryDetailSubscriptionDiscountExpired::class,
        'subscription_discount_removed' => SubscriptionHistoryDetailSubscriptionDiscountRemoved::class,
        'subscription_item_added' => SubscriptionHistoryDetailSubscriptionItemAdded::class,
        'subscription_item_quantity_updated' => SubscriptionHistoryDetailSubscriptionItemQuantityUpdated::class,
        'subscription_item_removed' => SubscriptionHistoryDetailSubscriptionItemRemoved::class,
        'subscription_one_off_charge_applied' => SubscriptionHistoryDetailSubscriptionOneOffChargeApplied::class,
        'subscription_past_due' => SubscriptionHistoryDetailSubscriptionPastDue::class,
        'subscription_paused' => SubscriptionHistoryDetailSubscriptionPaused::class,
        'subscription_payment_attempted' => SubscriptionHistoryDetailSubscriptionPaymentAttempted::class,
        'subscription_payment_method_added' => SubscriptionHistoryDetailSubscriptionPaymentMethodAdded::class,
        'subscription_payment_method_removed' => SubscriptionHistoryDetailSubscriptionPaymentMethodRemoved::class,
        'subscription_payment_method_updated' => SubscriptionHistoryDetailSubscriptionPaymentMethodUpdated::class,
        'subscription_renewed' => SubscriptionHistoryDetailSubscriptionRenewed::class,
        'subscription_resumed' => SubscriptionHistoryDetailSubscriptionResumed::class,
        'subscription_scheduled_change_added' => SubscriptionHistoryDetailSubscriptionScheduledChangeAdded::class,
        'subscription_scheduled_change_removed' => SubscriptionHistoryDetailSubscriptionScheduledChangeRemoved::class,
        'subscription_scheduled_change_updated' => SubscriptionHistoryDetailSubscriptionScheduledChangeUpdated::class,
    ];

    public static function from(array $data): SubscriptionHistoryDetail
    {
        $detail = self::DETAILS[$data['action'] ?? ''] ?? SubscriptionHistoryDetailUndefined::class;

        return $detail::from($data);
    }
}
