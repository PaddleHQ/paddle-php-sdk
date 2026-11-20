<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Settings;

class CheckoutPaymentMethods
{
    private function __construct(
        public CheckoutPaymentMethodSetting $alipay,
        public CheckoutPaymentMethodSetting $applePay,
        public CheckoutPaymentMethodSetting $bancontact,
        public CheckoutPaymentMethodSetting $blik,
        public CheckoutPaymentMethodSetting $card,
        public CheckoutPaymentMethodSetting $googlePay,
        public CheckoutPaymentMethodSetting $ideal,
        public CheckoutPaymentMethodSetting $kakaoPay,
        public CheckoutPaymentMethodSetting $mbWay,
        public CheckoutPaymentMethodSetting $naverPay,
        public CheckoutPaymentMethodSetting $payco,
        public CheckoutPaymentMethodSetting $paypal,
        public CheckoutPaymentMethodSetting $pix,
        public CheckoutPaymentMethodSetting $samsungPay,
        public CheckoutPaymentMethodSetting $southKoreaLocalCard,
        public CheckoutPaymentMethodSetting $upi,
        public CheckoutPaymentMethodSetting $wechatPay,
    ) {
    }

    public static function from(array $data): self
    {
        return new self(
            alipay: CheckoutPaymentMethodSetting::from($data['alipay']),
            applePay: CheckoutPaymentMethodSetting::from($data['apple_pay']),
            bancontact: CheckoutPaymentMethodSetting::from($data['bancontact']),
            blik: CheckoutPaymentMethodSetting::from($data['blik']),
            card: CheckoutPaymentMethodSetting::from($data['card']),
            googlePay: CheckoutPaymentMethodSetting::from($data['google_pay']),
            ideal: CheckoutPaymentMethodSetting::from($data['ideal']),
            kakaoPay: CheckoutPaymentMethodSetting::from($data['kakao_pay']),
            mbWay: CheckoutPaymentMethodSetting::from($data['mb_way']),
            naverPay: CheckoutPaymentMethodSetting::from($data['naver_pay']),
            payco: CheckoutPaymentMethodSetting::from($data['payco']),
            paypal: CheckoutPaymentMethodSetting::from($data['paypal']),
            pix: CheckoutPaymentMethodSetting::from($data['pix']),
            samsungPay: CheckoutPaymentMethodSetting::from($data['samsung_pay']),
            southKoreaLocalCard: CheckoutPaymentMethodSetting::from($data['south_korea_local_card']),
            upi: CheckoutPaymentMethodSetting::from($data['upi']),
            wechatPay: CheckoutPaymentMethodSetting::from($data['wechat_pay']),
        );
    }
}
