<?php

namespace Anguis\BlackFriday\Entity;

/**
 * Class ProductsEntity
 * @package Anguis\BlackFriday\Product
 */
class ProductEntity
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

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBasePriceNet(): float
    {
        return $this->base_price_net;
    }

    public function getMinimalPriceNet(): float
    {
        return $this->minimal_price_net;
    }
}