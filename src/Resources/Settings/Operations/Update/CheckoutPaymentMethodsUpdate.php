<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Settings\Operations\Update;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Undefined;

class CheckoutPaymentMethodsUpdate implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $alipay = new Undefined(),
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $applePay = new Undefined(),
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $bancontact = new Undefined(),
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $blik = new Undefined(),
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $card = new Undefined(),
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $googlePay = new Undefined(),
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $ideal = new Undefined(),
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $kakaoPay = new Undefined(),
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $mbWay = new Undefined(),
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $naverPay = new Undefined(),
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $payco = new Undefined(),
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $paypal = new Undefined(),
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $pix = new Undefined(),
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $samsungPay = new Undefined(),
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $southKoreaLocalCard = new Undefined(),
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $upi = new Undefined(),
        public readonly CheckoutPaymentMethodSettingUpdate|Undefined $wechatPay = new Undefined(),
    ) {
    }

    public function jsonSerialize(): \stdClass
    {
        return (object) $this->filterUndefined([
            'alipay' => $this->alipay,
            'apple_pay' => $this->applePay,
            'bancontact' => $this->bancontact,
            'blik' => $this->blik,
            'card' => $this->card,
            'google_pay' => $this->googlePay,
            'ideal' => $this->ideal,
            'kakao_pay' => $this->kakaoPay,
            'mb_way' => $this->mbWay,
            'naver_pay' => $this->naverPay,
            'payco' => $this->payco,
            'paypal' => $this->paypal,
            'pix' => $this->pix,
            'samsung_pay' => $this->samsungPay,
            'south_korea_local_card' => $this->southKoreaLocalCard,
            'upi' => $this->upi,
            'wechat_pay' => $this->wechatPay,
        ]);
    }
}
