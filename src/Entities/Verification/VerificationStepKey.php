<?php

declare(strict_types=1);

/**
 * |------
 * | ! Generated code !
 * | Altering this code will result in changes being overwritten |
 * |-------------------------------------------------------------|.
 */

namespace Paddle\SDK\Entities\Verification;

use Paddle\SDK\PaddleEnum;

/**
 * @method static VerificationStepKey AccountSetup()
 * @method static VerificationStepKey DomainReview()
 * @method static VerificationStepKey BusinessIdentification()
 * @method static VerificationStepKey IdentityVerification()
 * @method static VerificationStepKey FinalReview()
 * @method static VerificationStepKey AutomatedReview()
 */
final class VerificationStepKey extends PaddleEnum
{
    private const AccountSetup = 'account_setup';
    private const DomainReview = 'domain_review';
    private const BusinessIdentification = 'business_identification';
    private const IdentityVerification = 'identity_verification';
    private const FinalReview = 'final_review';
    private const AutomatedReview = 'automated_review';
}
