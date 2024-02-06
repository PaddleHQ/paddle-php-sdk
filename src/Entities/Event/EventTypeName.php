<?php

declare(strict_types=1);

namespace Paddle\SDK\Entities\Event;

enum EventTypeName: string
{
    case AddressCreated = 'address.created';
    case AddressUpdated = 'address.updated';
    case AdjustmentCreated = 'adjustment.created';
    case AdjustmentUpdated = 'adjustment.updated';
    case BusinessCreated = 'business.created';
    case BusinessUpdated = 'business.updated';
    case CustomerCreated = 'customer.created';
    case CustomerImported = 'customer.imported';
    case CustomerUpdated = 'customer.updated';
    case DiscountCreated = 'discount.created';
    case DiscountImported = 'discount.imported';
    case DiscountUpdated = 'discount.updated';
    case InvoiceCanceled = 'invoice.canceled';
    case InvoiceCreated = 'invoice.created';
    case InvoiceIssued = 'invoice.issued';
    case InvoiceOverdue = 'invoice.overdue';
    case InvoicePaid = 'invoice.paid';
    case InvoiceScheduled = 'invoice.scheduled';
    case PayoutCreated = 'payout.created';
    case PayoutPaid = 'payout.paid';
    case PriceCreated = 'price.created';
    case PriceUpdated = 'price.updated';
    case PriceImported = 'price.imported';
    case ProductCreated = 'product.created';
    case ProductUpdated = 'product.updated';
    case ProductImported = 'product.imported';
    case SubscriptionActivated = 'subscription.activated';
    case SubscriptionCanceled = 'subscription.canceled';
    case SubscriptionCreated = 'subscription.created';
    case SubscriptionImported = 'subscription.imported';
    case SubscriptionPastDue = 'subscription.past_due';
    case SubscriptionPaused = 'subscription.paused';
    case SubscriptionResumed = 'subscription.resumed';
    case SubscriptionTrialing = 'subscription.trialing';
    case SubscriptionUpdated = 'subscription.updated';
    case TransactionBilled = 'transaction.billed';
    case TransactionCanceled = 'transaction.canceled';
    case TransactionCompleted = 'transaction.completed';
    case TransactionCreated = 'transaction.created';
    case TransactionPaid = 'transaction.paid';
    case TransactionPastDue = 'transaction.past_due';
    case TransactionPaymentFailed = 'transaction.payment_failed';
    case TransactionReady = 'transaction.ready';
    case TransactionUpdated = 'transaction.updated';
    case ReportCreated = 'report.created';
    case ReportUpdated = 'report.updated';
}
