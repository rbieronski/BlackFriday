<?php

namespace Anguis\BlackFriday\Entity;

use Anguis\BlackFriday\Product\ProductsRepository;
use Anguis\BlackFriday\Promo\PromoEntity;

/**
 * Class SkuRepository
 * @author rbieronski <bluenow@gmail.com>
 */
class Product
{
    protected ProductsRepository $productsRepository;
    protected PromoEntity $promoRepository;

    function __construct(
        ProductsRepository $productsRepository,
        PromoEntity $promoRepository
    ) {
        $this->sku = $sku;
        $this->name = $name;
        $this->base_price=$base_price;
        $this->promo_price=$promo_price;
    }

    private function mergeSources
    {

    }
}