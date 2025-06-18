# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

Check our main [developer changelog](https://developer.paddle.com/?utm_source=dx&utm_medium=paddle-php-sdk) for information about changes to the Paddle Billing platform, the Paddle API, and other developer tools.

## [1.9.1] - 2025-02-18

### Fixed

- An error where `stored_payment_method_id` was not returned for past due subscriptions when using `getPaymentMethodChangeTransaction`

## [1.9.0] - 2025-01-30

### Added

- Added `transactions.revise` operation to revise a transaction and added `revised_at` to `Transaction` entity, see [related changelog](https://developer.paddle.com/changelog/2024/revise-transaction-customer-information?utm_source=dx&utm_medium=paddle-php-sdk).
- Added support for `transaction.revised` notification, see [related changelog](https://developer.paddle.com/changelog/2024/revise-transaction-customer-information?utm_source=dx&utm_medium=paddle-php-sdk).
- Support for partial simulation payloads, see [related changelog](https://developer.paddle.com/changelog/2025/existing-data-simulations?utm_source=dx&utm_medium=paddle-php-sdk)

### Fixed
- Handle known entity types for events that are not supported by the current SDK version. `UndefinedEvent` will always return an `UndefinedEntity`.

## [1.8.0] - 2024-12-19

### Added

- Added `on_resume` support to subscription resume and pause operations

## [1.7.2] - 2024-12-17

### Fixed

- Adjustment items can be omitted for when adjustment type is full

## [1.7.1] - 2024-12-13

### Fixed

- Subscription discount now supports null `starts_at`

## [1.7.0] - 2024-12-11

### Added

- Support for adjustment type, see [related changelog](https://developer.paddle.com/changelog/2024/refund-credit-full-total?utm_source=dx&utm_medium=paddle-php-sdk)
- Added Vietnamese Dong (`VND`) as a supported currency for payments [related changelog](https://developer.paddle.com/changelog/2024/vietnamese-dong-vnd-supported-currency?utm_source=dx&utm_medium=paddle-php-sdk)

## [1.6.0] - 2024-12-05

### Added

- Support for customer portal sessions, see [related changelog](https://developer.paddle.com/changelog/2024/customer-portal-sessions?utm_source=dx&utm_medium=paddle-php-sdk)
  - `Client->customerPortalSessions->create()`

### Fixed

- `Client->notifications->replay()` now calls the correct endpoint
- Subscription transaction line items now include proration (`nextTransaction`, `recurringTransactionDetails`, `immediateTransaction`)
- Transaction preview line items now include proration

## [1.5.0] - 2024-11-18

### Added

- Support for saved payment methods, see [related changelog](https://developer.paddle.com/changelog/2024/saved-payment-methods?utm_source=dx&utm_medium=paddle-php-sdk)
  - `Client->paymentMethods->list()`
  - `Client->paymentMethods->get()`
  - `Client->paymentMethods->delete()`
  - `Client->customers->generateAuthToken()`

## [1.4.0] - 2024-10-17

### Added

- Added simulations api [related changelog](https://developer.paddle.com/changelog/2024/webhook-simulator?utm_source=dx&utm_medium=paddle-php-sdk)
- Added `traffic_source` property to `NotificationSetting` entity
- Support notification settings `traffic_source` filter
- Support new payment methods `offline`, `unknown`, `wire_transfer`
- Support `tax_rates_used` property on `Adjustment` entity

### Fixed

- Dropped `receipt_data` on create and preview of a one-time charge for Subscriptions and Transactions
- `TransactionsClient::preview()` `TransactionPreview` response now allows null IDs for non-catalog prices and products:
  - `items[]->price` can now return `Price` (with `id`) or `TransactionPreviewPrice` (with nullable `id`)
  - `details->lineItems[]->priceId` is now nullable
  - `items[]->priceId` is now nullable
  - `details->lineItems[]->product` can now return `Product` (with `id`) or `TransactionPreviewProduct` (with nullable `id`)
- Empty custom data array will now serialize to empty JSON object `{}`
- `EventsClient::list` and `Notification->payload` will now return `UndefinedEvent` for unknown event types.

### Added
- `TransactionsClient::create()` now supports operation items with optional properties:
  - `Resources\Transactions\Operations\Create\TransactionCreateItem`
  - `Resources\Transactions\Operations\Create\TransactionCreateItemWithPrice`
- `TransactionsClient::update()` now supports operation items with optional properties:
  - `Resources\Transactions\Operations\Update\TransactionUpdateItem`
  - `Resources\Transactions\Operations\Update\TransactionUpdateItemWithPrice`
- `TransactionsClient::preview()` now supports operation items with optional properties:
  - `Resources\Transactions\Operations\Preview\TransactionItemPreviewWithNonCatalogPrice`
  - `Resources\Transactions\Operations\Preview\TransactionItemPreviewWithPriceId`

### Deprecated
- `TransactionsClient::create()` operation items have been deprecated:
  - `Entities\Transaction\TransactionCreateItem`
  - `Entities\Transaction\TransactionCreateItemWithPrice`
- `TransactionsClient::update()` operation items have been deprecated:
  - `Entities\Transaction\TransactionUpdateTransactionItem`
- `TransactionsClient::preview()` operation items have been deprecated:
  - `Entities\Transaction\TransactionItemPreviewWithNonCatalogPrice`
  - `Entities\Transaction\TransactionItemPreviewWithPriceId`

# [1.3.1] - 2024-09-30

### Fixed

- Update version reference to match package version

## [1.3.0] - 2024-09-30

### Added

- Added `AdjustmentsClient::getCreditNote`, see [related changelog](https://developer.paddle.com/changelog/2024/generate-adjustments-credit-notes)

## [1.2.0] - 2024-09-18

### Added

- Added `product` to `subscription.items[]`, see [related changelog](https://developer.paddle.com/changelog/2024/subscription-items-product?utm_source=dx&utm_medium=paddle-php-sdk)
- Support for `createdAt` and `updatedAt` on Subscription notification prices
- Support custom prices when updating and previewing subscriptions, see [related changelog](https://developer.paddle.com/changelog/2024/add-custom-items-subscription)
- `TransactionsClient::getInvoicePDF` now supports `disposition` parameter, see [related changelog](https://developer.paddle.com/changelog/2024/invoice-pdf-open-in-browser)
- Support notification settings pagination, see [related changelog](https://developer.paddle.com/changelog/2024/notification-settings-pagination)
- Support notification settings `active` filter
- Support for `notification_id` on notification events

### Fixed

- `PreviewPrice` operation no longer allows empty `items`
- Transaction `payment_method_id` can be `string` or `null`

## [1.1.2] - 2024-08-23

### Fixed

- Fixed `TransactionTimePeriod`constructor, updated the visibility from private to public.

## [1.1.1] - 2024-08-21

### Fixed

- Fixed `CreateDiscount` and `UpdateDiscount` to support custom data

## [1.1.0] - 2024-04-30

### Added

- New error code for payments `declined_not_retryable`, see [related changelog](https://developer.paddle.com/changelog/2024/declined-not-retryable-error-code?utm_source=dx&utm_medium=paddle-php-sdk).

## [1.0.1] - 2024-03-13

### Added

- `Address` and `Business` entities now include `customer_id` property, see [related changelog](https://developer.paddle.com/changelog/2024/address-business-webhooks-customer-id?utm_source=dx&utm_medium=paddle-php-sdk).
-  Two new report types `product_prices` and `discounts`, see [related changelog](https://developer.paddle.com/changelog/2024/product-prices-discounts-reports?utm_source=dx&utm_medium=paddle-php-sdk).
- `Product` and `Prices` entities now support `created_at` and `updated_at` properties

## [1.0.0] - 2024-02-20

### Changed

- Migrated away from native enums to reduce the risk of breaking changes
- Made entities consistent with `array<Entity>` usage where Collections were used instead
- Notification classes are split from main API classes to allow for long term backwards compatability
- Subscription item `price` re-uses the `Price` entity
- Dropped `@internal` on most entities to prevent IDE warnings, utilising private constructors instead
- Events now utilise their type specific classes

### Added

- Update resume subscription `effective_from` field to accept RFC 3339 datetime or `immediately`
- Subscription notifications support newly added price object fields

## [0.3.0] - 2024-02-13

### Added

- Support for installing within Symfony 7 projects
- `EventTypeName` enum support for `customer.imported`, `address.imported` and `business.imported`
- `ReportFilterName` enum support for `action`
- `payment_method_id` to `TransactionPaymentAttempt` entity for Transaction payments
- List credit balances for a customer now supports filtering by `currency_code`
- Support for `receipt_data` on create and preview of a one-time charge for Subscriptions
- Support for `receipt_data` on Transactions
- Support for `import_meta` on Subscription notifications
- Support for `import_meta` and `custom_data` on Discount notifications

### Fixed

- Using the correct arguments for testing a Notification list `from` in `NotificationsClientTest`
- Refactored out duplicate entities where both `<Entity>` and `<Entity>WithIncludes` existed
- Renamed `AdjustmentsAdjustmentCollection` to `AdjustmentCollection` so it aligns with naming conventions
- Renamed Report objects for consistency within the SDK
- PHPCS has been upgraded and configured for `nullable_type_declaration` as well as `ordered_types`
- `ListNotification` operation uses consistent naming conventions with other operations
- Correct type of `current_billing_period` for Subscription notifications to be nullable
- Subscription preview fields `immediate_transaction`, `next_transaction` and `recurring_transaction_details` are optional
- `Transaction` entity now re-uses `Adjustment` entity for the `adjustments` field
- `SubscriptionNextTransaction` now maps `adjustments` to `SubscriptionAdjustmentPreview` objects
- Shared objects between `SubscriptionAdjustmentItem` and `AdjustmentItem` have been consolidated into the `Shared` namespace
- Conflicting request object `AdjustmentItem` has moved into the Operations namespace
- Make `currentBillingPeriod` nullable for Subscription notifications
- Status enums use consistent naming for `AdjustmentStatus`, `TransactionStatus` and `PaymentAttemptStatus`
- Renamed `TotalAdjustments` to `AdjustmentTotals` to align with naming conventions

### Deprecated

- `stored_payment_method_id` on `TransactionPaymentAttempt`, use `payment_method_id` instead

### Removed

- Unused Subscription objects have been removed, `SubscriptionTransaction`, `SubscriptionAdjustment` and `SubscriptionsTransactionCollection`

## [0.2.2] - 2024-01-29

### Fixed

- Fixed PDF invoice for transaction endpoint to correctly hit `/transactions/{transaction_id}/invoice`

## [0.2.1] - 2024-01-24

### Added

- Added `importMeta` to product, price, address, business, customer, discount and subscription entities
- Added `creditToBalance` to `transaction.details.payoutTotals` and `transaction.details.totals`
- Added `origin` query parameter to list transactions, see [related changelog](https://developer.paddle.com/changelog/2023/filter-transactions-origin?utm_source=dx&utm_medium=paddle-php-sdk).
- Added `available_payment_methods` to transaction with includes entity
- Added `email` query parameter to list customers, see [related changelog](https://developer.paddle.com/changelog/2024/filter-customers-email#filter-customers-by-email-address?utm_source=dx&utm_medium=paddle-php-sdk)

## [0.2.0] - 2024-01-23

### Changed

- Operations have been renamed to reduce import conflicts and the use of aliases
- Unused and abandoned dependency `php-http/message-factory` was removed

## [0.1.1] - 2024-01-15

### Fixed

- Resolved invalid streams being created for null payloads

## dev - 2024-01-10

### Added

- Added `available_payment_methods` to [transaction preview and pricing preview](https://developer.paddle.com/changelog/2023/available-payment-methods?utm_source=dx&utm_medium=paddle-php-sdk)
- Added non-catalog items to [subscriptions](https://developer.paddle.com/changelog/2023/bill-custom-items-one-time-subscription-charge?utm_source=dx&utm_medium=paddle-php-sdk)
- Added non catalog items to [transactions](https://developer.paddle.com/changelog/2023/add-custom-items-transaction?utm_source=dx&utm_medium=paddle-php-sdk)
- Added `on_payment_failure` to [subscriptions](https://developer.paddle.com/changelog/2023/payment-failure-behavior-update-subscription?utm_source=dx&utm_medium=paddle-php-sdk)

### Fixed

- Correctly handle optional `ends_at` for discount under Subscriptions entity.
- Correctly handle optional `resume_at` for scheduled change under Subscriptions entity.

## dev - 2024-01-05

### Added

- Added `reports->list()` to [list reports](https://developer.paddle.com/api-reference/reports/list-reports?utm_source=dx&utm_medium=paddle-php-sdk)
- Added `reports->create()` to [create a new report](https://developer.paddle.com/api-reference/reports/create-report?utm_source=dx&utm_medium=paddle-php-sdk)
- Added `reports->get()` to [get a report](https://developer.paddle.com/api-reference/reports/get-report?utm_source=dx&utm_medium=paddle-php-sdk)
- Added `reports->getReportCsv()` to [get a CSV file for a report](https://developer.paddle.com/api-reference/reports/get-report-csv?utm_source=dx&utm_medium=paddle-php-sdk)

## dev - 2023-12-14

### Added

- Initial early access release. Added support for the most frequently used Paddle Billing entities and API operations. Check the [README](README.md) for more information.
