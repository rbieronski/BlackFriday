<?php

namespace Anguis\BlackFriday\Entity;

class PromoEntity
{
    protected string $sku;
    protected float $discount;


    function __construct(
        string $sku,
        float $discount
    ) {
        $this->sku = $sku;
        $this->discount = $discount;
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getDiscount(): float
    {
        return $this->discount;
    }
}