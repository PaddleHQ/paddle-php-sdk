<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Event;

use Paddle\SDK\PaddleEnum;

/**
 * @method static EventTypeName AddressCreated()
 * @method static EventTypeName AddressImported()
 * @method static EventTypeName AddressUpdated()
 * @method static EventTypeName AdjustmentCreated()
 * @method static EventTypeName AdjustmentUpdated()
 * @method static EventTypeName BusinessCreated()
 * @method static EventTypeName BusinessImported()
 * @method static EventTypeName BusinessUpdated()
 * @method static EventTypeName CustomerCreated()
 * @method static EventTypeName CustomerImported()
 * @method static EventTypeName CustomerUpdated()
 * @method static EventTypeName DiscountCreated()
 * @method static EventTypeName DiscountImported()
 * @method static EventTypeName DiscountUpdated()
 * @method static EventTypeName InvoiceCanceled()
 * @method static EventTypeName InvoiceCreated()
 * @method static EventTypeName InvoiceIssued()
 * @method static EventTypeName InvoiceOverdue()
 * @method static EventTypeName InvoicePaid()
 * @method static EventTypeName InvoiceScheduled()
 * @method static EventTypeName PayoutCreated()
 * @method static EventTypeName PayoutPaid()
 * @method static EventTypeName PriceCreated()
 * @method static EventTypeName PriceUpdated()
 * @method static EventTypeName PriceImported()
 * @method static EventTypeName ProductCreated()
 * @method static EventTypeName ProductUpdated()
 * @method static EventTypeName ProductImported()
 * @method static EventTypeName SubscriptionActivated()
 * @method static EventTypeName SubscriptionCanceled()
 * @method static EventTypeName SubscriptionCreated()
 * @method static EventTypeName SubscriptionImported()
 * @method static EventTypeName SubscriptionPastDue()
 * @method static EventTypeName SubscriptionPaused()
 * @method static EventTypeName SubscriptionResumed()
 * @method static EventTypeName SubscriptionTrialing()
 * @method static EventTypeName SubscriptionUpdated()
 * @method static EventTypeName TransactionBilled()
 * @method static EventTypeName TransactionCanceled()
 * @method static EventTypeName TransactionCompleted()
 * @method static EventTypeName TransactionCreated()
 * @method static EventTypeName TransactionPaid()
 * @method static EventTypeName TransactionPastDue()
 * @method static EventTypeName TransactionPaymentFailed()
 * @method static EventTypeName TransactionReady()
 * @method static EventTypeName TransactionUpdated()
 * @method static EventTypeName ReportCreated()
 * @method static EventTypeName ReportUpdated()
 */
final class EventTypeName extends PaddleEnum
{
    private const AddressCreated = 'address.created';
    private const AddressImported = 'address.imported';
    private const AddressUpdated = 'address.updated';
    private const AdjustmentCreated = 'adjustment.created';
    private const AdjustmentUpdated = 'adjustment.updated';
    private const BusinessCreated = 'business.created';
    private const BusinessImported = 'business.imported';
    private const BusinessUpdated = 'business.updated';
    private const CustomerCreated = 'customer.created';
    private const CustomerImported = 'customer.imported';
    private const CustomerUpdated = 'customer.updated';
    private const DiscountCreated = 'discount.created';
    private const DiscountImported = 'discount.imported';
    private const DiscountUpdated = 'discount.updated';
    private const InvoiceCanceled = 'invoice.canceled';
    private const InvoiceCreated = 'invoice.created';
    private const InvoiceIssued = 'invoice.issued';
    private const InvoiceOverdue = 'invoice.overdue';
    private const InvoicePaid = 'invoice.paid';
    private const InvoiceScheduled = 'invoice.scheduled';
    private const PayoutCreated = 'payout.created';
    private const PayoutPaid = 'payout.paid';
    private const PriceCreated = 'price.created';
    private const PriceUpdated = 'price.updated';
    private const PriceImported = 'price.imported';
    private const ProductCreated = 'product.created';
    private const ProductUpdated = 'product.updated';
    private const ProductImported = 'product.imported';
    private const SubscriptionActivated = 'subscription.activated';
    private const SubscriptionCanceled = 'subscription.canceled';
    private const SubscriptionCreated = 'subscription.created';
    private const SubscriptionImported = 'subscription.imported';
    private const SubscriptionPastDue = 'subscription.past_due';
    private const SubscriptionPaused = 'subscription.paused';
    private const SubscriptionResumed = 'subscription.resumed';
    private const SubscriptionTrialing = 'subscription.trialing';
    private const SubscriptionUpdated = 'subscription.updated';
    private const TransactionBilled = 'transaction.billed';
    private const TransactionCanceled = 'transaction.canceled';
    private const TransactionCompleted = 'transaction.completed';
    private const TransactionCreated = 'transaction.created';
    private const TransactionPaid = 'transaction.paid';
    private const TransactionPastDue = 'transaction.past_due';
    private const TransactionPaymentFailed = 'transaction.payment_failed';
    private const TransactionReady = 'transaction.ready';
    private const TransactionUpdated = 'transaction.updated';
    private const ReportCreated = 'report.created';
    private const ReportUpdated = 'report.updated';
}
