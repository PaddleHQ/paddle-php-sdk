# Upgrading

All breaking changes prior to v1 will be documented in this file to assist with upgrading. 

## v0.2.0

This version includes a breaking change to the naming of operations. Prior to this version operations were commonly named `<type>Operation`, e.g. `CreateOperation` which posed problems when using more than one resource such as when creating a product and price. The new naming convention includes the resource to prevent the need of aliasing in these circumstances. e.g. `CreatePrice` and `CreateProduct`. 

To upgrade to `0.2.0` from any earlier version you will need to refactor your use of operations to use the new names. These follow a common pattern that can be seen below:

`Paddle\SDK\Resources\Prices\Operations\CreateOperation` => `Paddle\SDK\Resources\Prices\Operations\CreatePrice` 
`Paddle\SDK\Resources\Prices\Operations\UpdateOperation` => `Paddle\SDK\Resources\Prices\Operations\UpdatePrice` 
`Paddle\SDK\Resources\Prices\Operations\ListOperation` => `Paddle\SDK\Resources\Prices\Operations\ListPrices`

There are also some operations that are unique, these are detailed below:

`Paddle\SDK\Resources\PricingPreviews\Operations\PreviewPricesOperation` => `Paddle\SDK\Resources\PricingPreviews\Operations\PreviewPrice`
`\Paddle\SDK\Resources\Transactions\Operations\PreviewOperation` => `\Paddle\SDK\Resources\Transactions\Operations\PreviewTransaction`
`\Paddle\SDK\Resources\Subscriptions\Operations\CancelOperation` => `\Paddle\SDK\Resources\Subscriptions\Operations\CancelSubscription`
`\Paddle\SDK\Resources\Subscriptions\Operations\CreateOneTimeChargeOperation` => `\Paddle\SDK\Resources\Subscriptions\Operations\CreateOneTimeCharge`
`\Paddle\SDK\Resources\Subscriptions\Operations\PauseOperation` => `\Paddle\SDK\Resources\Subscriptions\Operations\PauseSubscription`
`\Paddle\SDK\Resources\Subscriptions\Operations\PreviewOneTimeChargeOperation` => `\Paddle\SDK\Resources\Subscriptions\Operations\PreviewOneTimeCharge`
`\Paddle\SDK\Resources\Subscriptions\Operations\PreviewUpdateOperation` => `\Paddle\SDK\Resources\Subscriptions\Operations\PreviewUpdateSubscription`
`\Paddle\SDK\Resources\Subscriptions\Operations\ResumeOperation` => `\Paddle\SDK\Resources\Subscriptions\Operations\ResumeSubscription`
