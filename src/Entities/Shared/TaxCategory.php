<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

use Paddle\SDK\PaddleEnum;

/**
 * @method static TaxCategory DigitalGoods()
 * @method static TaxCategory Ebooks()
 * @method static TaxCategory ImplementationServices()
 * @method static TaxCategory ProfessionalServices()
 * @method static TaxCategory Saas()
 * @method static TaxCategory SoftwareProgrammingServices()
 * @method static TaxCategory Standard()
 * @method static TaxCategory TrainingServices()
 * @method static TaxCategory WebsiteHosting()
 */
final class TaxCategory extends PaddleEnum
{
    private const DigitalGoods = 'digital-goods';
    private const Ebooks = 'ebooks';
    private const ImplementationServices = 'implementation-services';
    private const ProfessionalServices = 'professional-services';
    private const Saas = 'saas';
    private const SoftwareProgrammingServices = 'software-programming-services';
    private const Standard = 'standard';
    private const TrainingServices = 'training-services';
    private const WebsiteHosting = 'website-hosting';
}
