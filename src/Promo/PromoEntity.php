<?php

namespace Anguis\BlackFriday\Promo;

class PromoEntity
{
    protected string $sku;
    protected float $discount;

    function __construct(
        string $sku,
        float $discount
    )
    {
        $this->sku = $sku;
        $this->discount = $discount;
    }
}