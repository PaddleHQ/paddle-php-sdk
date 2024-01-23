# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/), and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

> **Important:** While in early access we may introduce breaking changes. Where we can, we'll tag breaking changes in this changelog and communicate ahead of time.

Check our main [developer changelog](https://developer.paddle.com/?utm_source=dx&utm_medium=paddle-php-sdk) for information about changes to the Paddle Billing platform, the Paddle API, and other developer tools.

## [0.2.0] - 2024-01-23

### Changed

- Operations have been renamed to reduce import conflicts and the use of aliases
- Unused and abandoned dependency `php-http/message-factory` was removed

## [0.1.1] - 2024-01-15

### Fixed

- Resolved invalid streams being created for null payloads

## dev - 2024-01-10

### Added

- Added `available_payment_methods` to [transaction preview and pricing preview](https://developer.paddle.com/changelog/2023/available-payment-methods?utm_source=dx&utm_medium=paddle-node-sdk)
- Added non-catalog items to [subscriptions](https://developer.paddle.com/changelog/2023/bill-custom-items-one-time-subscription-charge?utm_source=dx&utm_medium=paddle-node-sdk)
- Added non catalog items to [transactions](https://developer.paddle.com/changelog/2023/add-custom-items-transaction?utm_source=dx&utm_medium=paddle-node-sdk)
- Added `on_payment_failure` to [subscriptions](https://developer.paddle.com/changelog/2023/payment-failure-behavior-update-subscription?utm_source=dx&utm_medium=paddle-node-sdk)

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
