<?php

declare(strict_types=1);

namespace Paddle\SDK\Tests\Functional\Resources\Settings;

use GuzzleHttp\Psr7\Response;
use Http\Mock\Client as MockClient;
use Paddle\SDK\Client;
use Paddle\SDK\Entities\Settings\AudienceOptIn;
use Paddle\SDK\Entities\Settings\BalanceCurrency;
use Paddle\SDK\Entities\Settings\BalanceCurrencyCode;
use Paddle\SDK\Entities\Settings\CheckoutFeatures;
use Paddle\SDK\Entities\Settings\CheckoutPaymentMethodSettings;
use Paddle\SDK\Entities\Settings\CheckoutRecovery;
use Paddle\SDK\Entities\Settings\CheckoutRecoveryDiscountType;
use Paddle\SDK\Entities\Settings\CheckoutStylesOverlay;
use Paddle\SDK\Entities\Settings\CheckoutUrl;
use Paddle\SDK\Entities\Settings\CurrencyConversion;
use Paddle\SDK\Entities\Settings\CurrencyConversions;
use Paddle\SDK\Entities\Settings\DefaultTaxMode;
use Paddle\SDK\Entities\Settings\StatementDescriptorSettings;
use Paddle\SDK\Entities\Settings\TaxSettings;
use Paddle\SDK\Environment;
use Paddle\SDK\Options;
use Paddle\SDK\Resources\Settings\Operations\Update\CheckoutPaymentMethodSettingUpdate;
use Paddle\SDK\Resources\Settings\Operations\Update\CheckoutPaymentMethodsUpdate;
use Paddle\SDK\Resources\Settings\Operations\Update\CheckoutRecoveryDiscountUpdate;
use Paddle\SDK\Resources\Settings\Operations\Update\CurrencyConversionUpdate;
use Paddle\SDK\Resources\Settings\Operations\UpdateBalanceCurrency;
use Paddle\SDK\Resources\Settings\Operations\UpdateCheckoutFeatures;
use Paddle\SDK\Resources\Settings\Operations\UpdateCheckoutPaymentMethodSettings;
use Paddle\SDK\Resources\Settings\Operations\UpdateCheckoutRecovery;
use Paddle\SDK\Resources\Settings\Operations\UpdateCheckoutStylesOverlay;
use Paddle\SDK\Resources\Settings\Operations\UpdateCheckoutUrl;
use Paddle\SDK\Resources\Settings\Operations\UpdateCurrencyConversions;
use Paddle\SDK\Resources\Settings\Operations\UpdateStatementDescriptorSettings;
use Paddle\SDK\Resources\Settings\Operations\UpdateTaxSettings;
use Paddle\SDK\Tests\Utils\ReadsFixtures;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\RequestInterface;

class SettingsClientTest extends TestCase
{
    use ReadsFixtures;

    private MockClient $mockClient;
    private Client $client;

    public function setUp(): void
    {
        $this->mockClient = new MockClient();
        $this->client = new Client(
            apiKey: 'API_KEY_PLACEHOLDER',
            options: new Options(Environment::SANDBOX),
            httpClient: $this->mockClient);
    }

    /**
     * @test
     *
     * @dataProvider getOperationsProvider
     */
    public function get_hits_expected_uri_and_returns_setting(
        string $method,
        string $expectedPath,
        string $responseFixture,
        string $expectedEntity,
        \Closure $assertions,
    ): void {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture($responseFixture)));
        $setting = $this->client->settings->{$method}();
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('GET', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . $expectedPath,
            urldecode((string) $request->getUri()),
        );
        self::assertInstanceOf($expectedEntity, $setting);
        $assertions($setting);
    }

    public static function getOperationsProvider(): \Generator
    {
        yield 'Get balance currency' => [
            'getBalanceCurrency',
            '/settings/balance-currency',
            'response/balance_currency',
            BalanceCurrency::class,
            function (BalanceCurrency $setting): void {
                self::assertEquals(BalanceCurrencyCode::USD(), $setting->primary);
                self::assertEquals(BalanceCurrencyCode::USD(), $setting->preferred);
                self::assertEquals([BalanceCurrencyCode::USD()], $setting->enabled);
            },
        ];

        yield 'Get checkout features' => [
            'getCheckoutFeatures',
            '/settings/checkout-features',
            'response/checkout_features',
            CheckoutFeatures::class,
            function (CheckoutFeatures $setting): void {
                self::assertTrue($setting->discountsEnabled);
                self::assertEquals(AudienceOptIn::Choice(), $setting->audienceOptIn);
                self::assertTrue($setting->savedPaymentMethodsEnabled);
            },
        ];

        yield 'Get checkout payment method settings' => [
            'getCheckoutPaymentMethodSettings',
            '/settings/checkout-payment-methods',
            'response/checkout_payment_method_settings',
            CheckoutPaymentMethodSettings::class,
            function (CheckoutPaymentMethodSettings $setting): void {
                self::assertFalse($setting->paymentMethods->alipay->enabled);
                self::assertTrue($setting->paymentMethods->alipay->available);
                self::assertTrue($setting->paymentMethods->applePay->enabled);
                self::assertFalse($setting->paymentMethods->blik->available);
                self::assertTrue($setting->paymentMethods->card->enabled);
                self::assertTrue($setting->paymentMethods->paypal->enabled);
                self::assertFalse($setting->paymentMethods->southKoreaLocalCard->enabled);
                self::assertFalse($setting->paymentMethods->wechatPay->available);
            },
        ];

        yield 'Get checkout recovery' => [
            'getCheckoutRecovery',
            '/settings/checkout-recovery',
            'response/checkout_recovery',
            CheckoutRecovery::class,
            function (CheckoutRecovery $setting): void {
                self::assertTrue($setting->enabled);
                self::assertNotNull($setting->discount);
                self::assertEquals(CheckoutRecoveryDiscountType::Percentage(), $setting->discount->type);
                self::assertSame('10', $setting->discount->amount);
            },
        ];

        yield 'Get checkout recovery without discount' => [
            'getCheckoutRecovery',
            '/settings/checkout-recovery',
            'response/checkout_recovery_no_discount',
            CheckoutRecovery::class,
            function (CheckoutRecovery $setting): void {
                self::assertTrue($setting->enabled);
                self::assertNull($setting->discount);
            },
        ];

        yield 'Get checkout styles overlay' => [
            'getCheckoutStylesOverlay',
            '/settings/checkout-styles-overlay',
            'response/checkout_styles_overlay',
            CheckoutStylesOverlay::class,
            function (CheckoutStylesOverlay $setting): void {
                self::assertSame('#4F46E5', $setting->primaryCheckoutColor);
            },
        ];

        yield 'Get checkout styles overlay without color' => [
            'getCheckoutStylesOverlay',
            '/settings/checkout-styles-overlay',
            'response/checkout_styles_overlay_unset',
            CheckoutStylesOverlay::class,
            function (CheckoutStylesOverlay $setting): void {
                self::assertNull($setting->primaryCheckoutColor);
            },
        ];

        yield 'Get checkout URL' => [
            'getCheckoutUrl',
            '/settings/checkout-url',
            'response/checkout_url',
            CheckoutUrl::class,
            function (CheckoutUrl $setting): void {
                self::assertSame('https://example.com/buy', $setting->defaultUrl);
            },
        ];

        yield 'Get checkout URL without default' => [
            'getCheckoutUrl',
            '/settings/checkout-url',
            'response/checkout_url_unset',
            CheckoutUrl::class,
            function (CheckoutUrl $setting): void {
                self::assertNull($setting->defaultUrl);
            },
        ];

        yield 'Get currency conversions' => [
            'getCurrencyConversions',
            '/settings/currency-conversions',
            'response/currency_conversions',
            CurrencyConversions::class,
            function (CurrencyConversions $setting): void {
                self::assertCount(33, $setting->conversions);
                self::assertContainsOnlyInstancesOf(CurrencyConversion::class, $setting->conversions);
                self::assertTrue($setting->conversions['USD']->enabled);
                self::assertFalse($setting->conversions['GBP']->enabled);
                self::assertFalse($setting->conversions['ZAR']->enabled);
            },
        ];

        yield 'Get statement descriptor settings' => [
            'getStatementDescriptorSettings',
            '/settings/statement-descriptor',
            'response/statement_descriptor_settings',
            StatementDescriptorSettings::class,
            function (StatementDescriptorSettings $setting): void {
                self::assertSame('AEROEDIT', $setting->name);
                self::assertSame('PADDLE.NET* AEROEDIT', $setting->preview->default);
                self::assertSame('PAYPAL *PADDLE.NET', $setting->preview->paypal);
            },
        ];

        yield 'Get tax settings' => [
            'getTaxSettings',
            '/settings/tax',
            'response/tax_settings',
            TaxSettings::class,
            function (TaxSettings $setting): void {
                self::assertEquals(DefaultTaxMode::Exclusive(), $setting->defaultTaxMode);
            },
        ];
    }

    /**
     * @test
     *
     * @dataProvider updateOperationsProvider
     */
    public function it_uses_expected_payload_on_update(
        string $method,
        string $expectedPath,
        \JsonSerializable $operation,
        string $expectedBody,
        string $responseFixture,
        string $expectedEntity,
    ): void {
        $this->mockClient->addResponse(new Response(200, body: self::readRawJsonFixture($responseFixture)));
        $setting = $this->client->settings->{$method}($operation);
        $request = $this->mockClient->getLastRequest();

        self::assertInstanceOf(RequestInterface::class, $request);
        self::assertEquals('PATCH', $request->getMethod());
        self::assertEquals(
            Environment::SANDBOX->baseUrl() . $expectedPath,
            urldecode((string) $request->getUri()),
        );
        self::assertJsonStringEqualsJsonString($expectedBody, (string) $request->getBody());
        self::assertInstanceOf($expectedEntity, $setting);
    }

    public static function updateOperationsProvider(): \Generator
    {
        yield 'Update balance currency minimal' => [
            'updateBalanceCurrency',
            '/settings/balance-currency',
            new UpdateBalanceCurrency(preferred: BalanceCurrencyCode::GBP()),
            self::readRawJsonFixture('request/update_balance_currency_minimal'),
            'response/balance_currency_updated',
            BalanceCurrency::class,
        ];

        yield 'Update balance currency full' => [
            'updateBalanceCurrency',
            '/settings/balance-currency',
            new UpdateBalanceCurrency(preferred: BalanceCurrencyCode::EUR()),
            self::readRawJsonFixture('request/update_balance_currency_full'),
            'response/balance_currency_updated',
            BalanceCurrency::class,
        ];

        yield 'Update checkout features minimal' => [
            'updateCheckoutFeatures',
            '/settings/checkout-features',
            new UpdateCheckoutFeatures(discountsEnabled: true, audienceOptIn: AudienceOptIn::Choice()),
            self::readRawJsonFixture('request/update_checkout_features_minimal'),
            'response/checkout_features_updated',
            CheckoutFeatures::class,
        ];

        yield 'Update checkout features full' => [
            'updateCheckoutFeatures',
            '/settings/checkout-features',
            new UpdateCheckoutFeatures(
                discountsEnabled: false,
                audienceOptIn: AudienceOptIn::Never(),
                savedPaymentMethodsEnabled: false,
            ),
            self::readRawJsonFixture('request/update_checkout_features_full'),
            'response/checkout_features_updated',
            CheckoutFeatures::class,
        ];

        yield 'Update checkout payment methods minimal' => [
            'updateCheckoutPaymentMethodSettings',
            '/settings/checkout-payment-methods',
            new UpdateCheckoutPaymentMethodSettings(
                new CheckoutPaymentMethodsUpdate(
                    alipay: new CheckoutPaymentMethodSettingUpdate(false),
                    applePay: new CheckoutPaymentMethodSettingUpdate(true),
                ),
            ),
            self::readRawJsonFixture('request/update_checkout_payment_method_settings_minimal'),
            'response/checkout_payment_method_settings_updated',
            CheckoutPaymentMethodSettings::class,
        ];

        yield 'Update checkout payment methods full' => [
            'updateCheckoutPaymentMethodSettings',
            '/settings/checkout-payment-methods',
            new UpdateCheckoutPaymentMethodSettings(
                new CheckoutPaymentMethodsUpdate(
                    alipay: new CheckoutPaymentMethodSettingUpdate(true),
                    applePay: new CheckoutPaymentMethodSettingUpdate(false),
                    bancontact: new CheckoutPaymentMethodSettingUpdate(true),
                    blik: new CheckoutPaymentMethodSettingUpdate(false),
                    card: new CheckoutPaymentMethodSettingUpdate(true),
                    googlePay: new CheckoutPaymentMethodSettingUpdate(false),
                    ideal: new CheckoutPaymentMethodSettingUpdate(true),
                    kakaoPay: new CheckoutPaymentMethodSettingUpdate(false),
                    mbWay: new CheckoutPaymentMethodSettingUpdate(true),
                    naverPay: new CheckoutPaymentMethodSettingUpdate(false),
                    payco: new CheckoutPaymentMethodSettingUpdate(true),
                    paypal: new CheckoutPaymentMethodSettingUpdate(false),
                    pix: new CheckoutPaymentMethodSettingUpdate(true),
                    samsungPay: new CheckoutPaymentMethodSettingUpdate(false),
                    southKoreaLocalCard: new CheckoutPaymentMethodSettingUpdate(true),
                    upi: new CheckoutPaymentMethodSettingUpdate(false),
                    wechatPay: new CheckoutPaymentMethodSettingUpdate(true),
                ),
            ),
            self::readRawJsonFixture('request/update_checkout_payment_method_settings_full'),
            'response/checkout_payment_method_settings_updated',
            CheckoutPaymentMethodSettings::class,
        ];

        yield 'Update checkout recovery minimal' => [
            'updateCheckoutRecovery',
            '/settings/checkout-recovery',
            new UpdateCheckoutRecovery(
                enabled: true,
                discount: new CheckoutRecoveryDiscountUpdate(CheckoutRecoveryDiscountType::Percentage(), '10'),
            ),
            self::readRawJsonFixture('request/update_checkout_recovery_minimal'),
            'response/checkout_recovery_updated',
            CheckoutRecovery::class,
        ];

        yield 'Update checkout recovery full' => [
            'updateCheckoutRecovery',
            '/settings/checkout-recovery',
            new UpdateCheckoutRecovery(
                enabled: true,
                discount: new CheckoutRecoveryDiscountUpdate(CheckoutRecoveryDiscountType::Percentage(), '15'),
            ),
            self::readRawJsonFixture('request/update_checkout_recovery_full'),
            'response/checkout_recovery_updated',
            CheckoutRecovery::class,
        ];

        yield 'Update checkout recovery clearing discount' => [
            'updateCheckoutRecovery',
            '/settings/checkout-recovery',
            new UpdateCheckoutRecovery(discount: null),
            self::readRawJsonFixture('request/update_checkout_recovery_clear_discount'),
            'response/checkout_recovery_no_discount',
            CheckoutRecovery::class,
        ];

        yield 'Update checkout recovery with no fields sends empty body' => [
            'updateCheckoutRecovery',
            '/settings/checkout-recovery',
            new UpdateCheckoutRecovery(),
            '{}',
            'response/checkout_recovery_updated',
            CheckoutRecovery::class,
        ];

        yield 'Update checkout styles overlay minimal' => [
            'updateCheckoutStylesOverlay',
            '/settings/checkout-styles-overlay',
            new UpdateCheckoutStylesOverlay(primaryCheckoutColor: '#2E1065'),
            self::readRawJsonFixture('request/update_checkout_styles_overlay_minimal'),
            'response/checkout_styles_overlay_updated',
            CheckoutStylesOverlay::class,
        ];

        yield 'Update checkout styles overlay full' => [
            'updateCheckoutStylesOverlay',
            '/settings/checkout-styles-overlay',
            new UpdateCheckoutStylesOverlay(primaryCheckoutColor: '#4F46E5'),
            self::readRawJsonFixture('request/update_checkout_styles_overlay_full'),
            'response/checkout_styles_overlay_updated',
            CheckoutStylesOverlay::class,
        ];

        yield 'Update checkout styles overlay clearing color' => [
            'updateCheckoutStylesOverlay',
            '/settings/checkout-styles-overlay',
            new UpdateCheckoutStylesOverlay(primaryCheckoutColor: null),
            self::readRawJsonFixture('request/update_checkout_styles_overlay_clear_color'),
            'response/checkout_styles_overlay_unset',
            CheckoutStylesOverlay::class,
        ];

        yield 'Update checkout URL minimal' => [
            'updateCheckoutUrl',
            '/settings/checkout-url',
            new UpdateCheckoutUrl(defaultUrl: 'https://example.com/checkout'),
            self::readRawJsonFixture('request/update_checkout_url_minimal'),
            'response/checkout_url_updated',
            CheckoutUrl::class,
        ];

        yield 'Update checkout URL full' => [
            'updateCheckoutUrl',
            '/settings/checkout-url',
            new UpdateCheckoutUrl(defaultUrl: 'https://example.com/checkout'),
            self::readRawJsonFixture('request/update_checkout_url_full'),
            'response/checkout_url_updated',
            CheckoutUrl::class,
        ];

        yield 'Update checkout URL clearing default' => [
            'updateCheckoutUrl',
            '/settings/checkout-url',
            new UpdateCheckoutUrl(defaultUrl: null),
            self::readRawJsonFixture('request/update_checkout_url_clear'),
            'response/checkout_url_unset',
            CheckoutUrl::class,
        ];

        yield 'Update currency conversions minimal' => [
            'updateCurrencyConversions',
            '/settings/currency-conversions',
            new UpdateCurrencyConversions(['GBP' => new CurrencyConversionUpdate(true)]),
            self::readRawJsonFixture('request/update_currency_conversions_minimal'),
            'response/currency_conversions_updated',
            CurrencyConversions::class,
        ];

        yield 'Update currency conversions full' => [
            'updateCurrencyConversions',
            '/settings/currency-conversions',
            new UpdateCurrencyConversions([
                'GBP' => new CurrencyConversionUpdate(true),
                'USD' => new CurrencyConversionUpdate(false),
                'JPY' => new CurrencyConversionUpdate(true),
            ]),
            self::readRawJsonFixture('request/update_currency_conversions_full'),
            'response/currency_conversions_updated',
            CurrencyConversions::class,
        ];

        yield 'Update statement descriptor minimal' => [
            'updateStatementDescriptorSettings',
            '/settings/statement-descriptor',
            new UpdateStatementDescriptorSettings(name: 'AEROEDIT'),
            self::readRawJsonFixture('request/update_statement_descriptor_settings_minimal'),
            'response/statement_descriptor_settings_updated',
            StatementDescriptorSettings::class,
        ];

        yield 'Update statement descriptor full' => [
            'updateStatementDescriptorSettings',
            '/settings/statement-descriptor',
            new UpdateStatementDescriptorSettings(name: 'AERO EDIT'),
            self::readRawJsonFixture('request/update_statement_descriptor_settings_full'),
            'response/statement_descriptor_settings_updated',
            StatementDescriptorSettings::class,
        ];

        yield 'Update tax settings minimal' => [
            'updateTaxSettings',
            '/settings/tax',
            new UpdateTaxSettings(defaultTaxMode: DefaultTaxMode::Inclusive()),
            self::readRawJsonFixture('request/update_tax_settings_minimal'),
            'response/tax_settings_updated',
            TaxSettings::class,
        ];

        yield 'Update tax settings full' => [
            'updateTaxSettings',
            '/settings/tax',
            new UpdateTaxSettings(defaultTaxMode: DefaultTaxMode::Location()),
            self::readRawJsonFixture('request/update_tax_settings_full'),
            'response/tax_settings_updated',
            TaxSettings::class,
        ];
    }

    /** @test */
    public function update_omits_undefined_fields(): void
    {
        $this->mockClient->addResponse(
            new Response(200, body: self::readRawJsonFixture('response/checkout_features_updated')),
        );
        $this->client->settings->updateCheckoutFeatures(new UpdateCheckoutFeatures(discountsEnabled: false));
        $request = $this->mockClient->getLastRequest();

        self::assertJsonStringEqualsJsonString('{"discounts_enabled": false}', (string) $request->getBody());
    }

    /** @test */
    public function update_checkout_payment_methods_omits_undefined_methods(): void
    {
        $this->mockClient->addResponse(
            new Response(200, body: self::readRawJsonFixture('response/checkout_payment_method_settings_updated')),
        );
        $this->client->settings->updateCheckoutPaymentMethodSettings(
            new UpdateCheckoutPaymentMethodSettings(
                new CheckoutPaymentMethodsUpdate(card: new CheckoutPaymentMethodSettingUpdate(true)),
            ),
        );
        $request = $this->mockClient->getLastRequest();

        self::assertJsonStringEqualsJsonString(
            '{"payment_methods": {"card": {"enabled": true}}}',
            (string) $request->getBody(),
        );
    }

    /** @test */
    public function update_checkout_payment_methods_sends_empty_object_when_no_methods_given(): void
    {
        $this->mockClient->addResponse(
            new Response(200, body: self::readRawJsonFixture('response/checkout_payment_method_settings_updated')),
        );
        $this->client->settings->updateCheckoutPaymentMethodSettings(
            new UpdateCheckoutPaymentMethodSettings(new CheckoutPaymentMethodsUpdate()),
        );
        $request = $this->mockClient->getLastRequest();

        self::assertSame('{"payment_methods":{}}', (string) $request->getBody());
    }
}
