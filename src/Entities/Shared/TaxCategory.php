<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Shared;

enum TaxCategory: string
{
    case DigitalGoods = 'digital-goods';
    case Ebooks = 'ebooks';
    case ImplementationServices = 'implementation-services';
    case ProfessionalServices = 'professional-services';
    case Saas = 'saas';
    case SoftwareProgrammingServices = 'software-programming-services';
    case Standard = 'standard';
    case TrainingServices = 'training-services';
    case WebsiteHosting = 'website-hosting';
}
