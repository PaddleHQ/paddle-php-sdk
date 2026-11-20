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
 * @method static SubscriptionHistoryAction SubscriptionActivated()
 * @method static SubscriptionHistoryAction SubscriptionAddressUpdated()
 * @method static SubscriptionHistoryAction SubscriptionBillingCycleUpdated()
 * @method static SubscriptionHistoryAction SubscriptionBillingDateUpdated()
 * @method static SubscriptionHistoryAction SubscriptionBillingDetailsUpdated()
 * @method static SubscriptionHistoryAction SubscriptionBusinessAdded()
 * @method static SubscriptionHistoryAction SubscriptionBusinessRemoved()
 * @method static SubscriptionHistoryAction SubscriptionBusinessUpdated()
 * @method static SubscriptionHistoryAction SubscriptionCanceled()
 * @method static SubscriptionHistoryAction SubscriptionCollectionModeUpdated()
 * @method static SubscriptionHistoryAction SubscriptionConsentRequirementGranted()
 * @method static SubscriptionHistoryAction SubscriptionCreated()
 * @method static SubscriptionHistoryAction SubscriptionCurrencyUpdated()
 * @method static SubscriptionHistoryAction SubscriptionCustomDataUpdated()
 * @method static SubscriptionHistoryAction SubscriptionCustomerUpdated()
 * @method static SubscriptionHistoryAction SubscriptionDiscountAdded()
 * @method static SubscriptionHistoryAction SubscriptionDiscountExpired()
 * @method static SubscriptionHistoryAction SubscriptionDiscountRemoved()
 * @method static SubscriptionHistoryAction SubscriptionItemAdded()
 * @method static SubscriptionHistoryAction SubscriptionItemQuantityUpdated()
 * @method static SubscriptionHistoryAction SubscriptionItemRemoved()
 * @method static SubscriptionHistoryAction SubscriptionOneOffChargeApplied()
 * @method static SubscriptionHistoryAction SubscriptionPastDue()
 * @method static SubscriptionHistoryAction SubscriptionPaused()
 * @method static SubscriptionHistoryAction SubscriptionPaymentAttempted()
 * @method static SubscriptionHistoryAction SubscriptionPaymentMethodAdded()
 * @method static SubscriptionHistoryAction SubscriptionPaymentMethodRemoved()
 * @method static SubscriptionHistoryAction SubscriptionPaymentMethodUpdated()
 * @method static SubscriptionHistoryAction SubscriptionRenewed()
 * @method static SubscriptionHistoryAction SubscriptionResumed()
 * @method static SubscriptionHistoryAction SubscriptionScheduledChangeAdded()
 * @method static SubscriptionHistoryAction SubscriptionScheduledChangeRemoved()
 * @method static SubscriptionHistoryAction SubscriptionScheduledChangeUpdated()
 */
final class SubscriptionHistoryAction extends PaddleEnum
{
    private const SubscriptionActivated = 'subscription_activated';
    private const SubscriptionAddressUpdated = 'subscription_address_updated';
    private const SubscriptionBillingCycleUpdated = 'subscription_billing_cycle_updated';
    private const SubscriptionBillingDateUpdated = 'subscription_billing_date_updated';
    private const SubscriptionBillingDetailsUpdated = 'subscription_billing_details_updated';
    private const SubscriptionBusinessAdded = 'subscription_business_added';
    private const SubscriptionBusinessRemoved = 'subscription_business_removed';
    private const SubscriptionBusinessUpdated = 'subscription_business_updated';
    private const SubscriptionCanceled = 'subscription_canceled';
    private const SubscriptionCollectionModeUpdated = 'subscription_collection_mode_updated';
    private const SubscriptionConsentRequirementGranted = 'subscription_consent_requirement_granted';
    private const SubscriptionCreated = 'subscription_created';
    private const SubscriptionCurrencyUpdated = 'subscription_currency_updated';
    private const SubscriptionCustomDataUpdated = 'subscription_custom_data_updated';
    private const SubscriptionCustomerUpdated = 'subscription_customer_updated';
    private const SubscriptionDiscountAdded = 'subscription_discount_added';
    private const SubscriptionDiscountExpired = 'subscription_discount_expired';
    private const SubscriptionDiscountRemoved = 'subscription_discount_removed';
    private const SubscriptionItemAdded = 'subscription_item_added';
    private const SubscriptionItemQuantityUpdated = 'subscription_item_quantity_updated';
    private const SubscriptionItemRemoved = 'subscription_item_removed';
    private const SubscriptionOneOffChargeApplied = 'subscription_one_off_charge_applied';
    private const SubscriptionPastDue = 'subscription_past_due';
    private const SubscriptionPaused = 'subscription_paused';
    private const SubscriptionPaymentAttempted = 'subscription_payment_attempted';
    private const SubscriptionPaymentMethodAdded = 'subscription_payment_method_added';
    private const SubscriptionPaymentMethodRemoved = 'subscription_payment_method_removed';
    private const SubscriptionPaymentMethodUpdated = 'subscription_payment_method_updated';
    private const SubscriptionRenewed = 'subscription_renewed';
    private const SubscriptionResumed = 'subscription_resumed';
    private const SubscriptionScheduledChangeAdded = 'subscription_scheduled_change_added';
    private const SubscriptionScheduledChangeRemoved = 'subscription_scheduled_change_removed';
    private const SubscriptionScheduledChangeUpdated = 'subscription_scheduled_change_updated';
}
