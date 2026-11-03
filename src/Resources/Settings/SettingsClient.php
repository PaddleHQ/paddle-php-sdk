<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Resources\Settings;

use Paddle\SDK\Client;
use Paddle\SDK\Entities\Settings\BalanceCurrency;
use Paddle\SDK\Entities\Settings\CheckoutFeatures;
use Paddle\SDK\Entities\Settings\CheckoutPaymentMethodSettings;
use Paddle\SDK\Entities\Settings\CheckoutRecovery;
use Paddle\SDK\Entities\Settings\CheckoutStylesOverlay;
use Paddle\SDK\Entities\Settings\CheckoutUrl;
use Paddle\SDK\Entities\Settings\CurrencyConversions;
use Paddle\SDK\Entities\Settings\StatementDescriptorSettings;
use Paddle\SDK\Entities\Settings\TaxSettings;
use Paddle\SDK\Exceptions\ApiError;
use Paddle\SDK\Exceptions\SdkExceptions\MalformedResponse;
use Paddle\SDK\Resources\Settings\Operations\UpdateBalanceCurrency;
use Paddle\SDK\Resources\Settings\Operations\UpdateCheckoutFeatures;
use Paddle\SDK\Resources\Settings\Operations\UpdateCheckoutPaymentMethodSettings;
use Paddle\SDK\Resources\Settings\Operations\UpdateCheckoutRecovery;
use Paddle\SDK\Resources\Settings\Operations\UpdateCheckoutStylesOverlay;
use Paddle\SDK\Resources\Settings\Operations\UpdateCheckoutUrl;
use Paddle\SDK\Resources\Settings\Operations\UpdateCurrencyConversions;
use Paddle\SDK\Resources\Settings\Operations\UpdateStatementDescriptorSettings;
use Paddle\SDK\Resources\Settings\Operations\UpdateTaxSettings;
use Paddle\SDK\ResponseParser;

class SettingsClient
{
    public function __construct(
        private readonly Client $client,
    ) {
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getBalanceCurrency(): BalanceCurrency
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/settings/balance-currency'),
        );

        return BalanceCurrency::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function updateBalanceCurrency(UpdateBalanceCurrency $operation): BalanceCurrency
    {
        $parser = new ResponseParser(
            $this->client->patchRaw('/settings/balance-currency', $operation),
        );

        return BalanceCurrency::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getCheckoutFeatures(): CheckoutFeatures
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/settings/checkout-features'),
        );

        return CheckoutFeatures::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function updateCheckoutFeatures(UpdateCheckoutFeatures $operation): CheckoutFeatures
    {
        $parser = new ResponseParser(
            $this->client->patchRaw('/settings/checkout-features', $operation),
        );

        return CheckoutFeatures::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getCheckoutPaymentMethodSettings(): CheckoutPaymentMethodSettings
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/settings/checkout-payment-methods'),
        );

        return CheckoutPaymentMethodSettings::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function updateCheckoutPaymentMethodSettings(UpdateCheckoutPaymentMethodSettings $operation): CheckoutPaymentMethodSettings
    {
        $parser = new ResponseParser(
            $this->client->patchRaw('/settings/checkout-payment-methods', $operation),
        );

        return CheckoutPaymentMethodSettings::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getCheckoutRecovery(): CheckoutRecovery
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/settings/checkout-recovery'),
        );

        return CheckoutRecovery::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function updateCheckoutRecovery(UpdateCheckoutRecovery $operation): CheckoutRecovery
    {
        $parser = new ResponseParser(
            $this->client->patchRaw('/settings/checkout-recovery', $operation),
        );

        return CheckoutRecovery::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getCheckoutStylesOverlay(): CheckoutStylesOverlay
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/settings/checkout-styles-overlay'),
        );

        return CheckoutStylesOverlay::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function updateCheckoutStylesOverlay(UpdateCheckoutStylesOverlay $operation): CheckoutStylesOverlay
    {
        $parser = new ResponseParser(
            $this->client->patchRaw('/settings/checkout-styles-overlay', $operation),
        );

        return CheckoutStylesOverlay::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getCheckoutUrl(): CheckoutUrl
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/settings/checkout-url'),
        );

        return CheckoutUrl::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function updateCheckoutUrl(UpdateCheckoutUrl $operation): CheckoutUrl
    {
        $parser = new ResponseParser(
            $this->client->patchRaw('/settings/checkout-url', $operation),
        );

        return CheckoutUrl::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getCurrencyConversions(): CurrencyConversions
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/settings/currency-conversions'),
        );

        return CurrencyConversions::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function updateCurrencyConversions(UpdateCurrencyConversions $operation): CurrencyConversions
    {
        $parser = new ResponseParser(
            $this->client->patchRaw('/settings/currency-conversions', $operation),
        );

        return CurrencyConversions::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getStatementDescriptorSettings(): StatementDescriptorSettings
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/settings/statement-descriptor'),
        );

        return StatementDescriptorSettings::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function updateStatementDescriptorSettings(UpdateStatementDescriptorSettings $operation): StatementDescriptorSettings
    {
        $parser = new ResponseParser(
            $this->client->patchRaw('/settings/statement-descriptor', $operation),
        );

        return StatementDescriptorSettings::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function getTaxSettings(): TaxSettings
    {
        $parser = new ResponseParser(
            $this->client->getRaw('/settings/tax'),
        );

        return TaxSettings::from($parser->getData());
    }

    /**
     * @throws ApiError          On a generic API error
     * @throws MalformedResponse If the API response was not parsable
     */
    public function updateTaxSettings(UpdateTaxSettings $operation): TaxSettings
    {
        $parser = new ResponseParser(
            $this->client->patchRaw('/settings/tax', $operation),
        );

        return TaxSettings::from($parser->getData());
    }
}
