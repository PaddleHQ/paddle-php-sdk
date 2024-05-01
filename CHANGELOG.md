# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

Check our main [developer changelog](https://developer.paddle.com/?utm_source=dx&utm_medium=paddle-php-sdk) for information about changes to the Paddle Billing platform, the Paddle API, and other developer tools.

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
