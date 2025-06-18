<?php

declare(strict_types=1);

namespace Paddle\SDK\Resources\Transactions\Operations;

use Paddle\SDK\FiltersUndefined;
use Paddle\SDK\Resources\Transactions\Operations\Revise\TransactionReviseAddress;
use Paddle\SDK\Resources\Transactions\Operations\Revise\TransactionReviseBusiness;
use Paddle\SDK\Resources\Transactions\Operations\Revise\TransactionReviseCustomer;
use Paddle\SDK\Undefined;

class ReviseTransaction implements \JsonSerializable
{
    use FiltersUndefined;

    public function __construct(
        public readonly TransactionReviseAddress|Undefined|null $address = new Undefined(),
        public readonly TransactionReviseBusiness|Undefined|null $business = new Undefined(),
        public readonly TransactionReviseCustomer|Undefined|null $customer = new Undefined(),
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->filterUndefined([
            'address' => $this->address,
            'customer' => $this->customer,
            'business' => $this->business,
        ]);
    }
}
