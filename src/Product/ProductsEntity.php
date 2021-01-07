<?php

namespace Anguis\BlackFriday\Product;

/**
 * Class ProductsEntity
 * @package Anguis\BlackFriday\Product
 */
class ProductsEntity
{
    protected string $sku;
    protected string $name;
    protected float $base_price_net;
    protected float $minimal_price_net;

    function __construct(
        string $sku,
        string $name,
        float $base_price_net,
        float $minimal_price_net
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->base_price_net = $base_price_net;
        $this->minimal_price_net = $minimal_price_net;
    }
}