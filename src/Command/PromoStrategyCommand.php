<?php

namespace Anguis\BlackFriday\Command;

use Anguis\BlackFriday\Collection\Collection;
use Anguis\BlackFriday\Product\ProductsCollection;
use Anguis\BlackFriday\Promo\PromosCollection;

class PromoStrategyCommand implements CommandInterface {

    const STRING_SEPARATOR = " ";
    const TAX_PERCENTAGE = 23;

    protected Collection $products;
    protected Collection $promos;
    protected string $result;

    function __construct(
                Collection $products,
                Collection  $promos
    ) {
        $this->products = $products;
        $this->promos = $promos;
    }

    public function Run(): string
    {
        $productKeys = $this->products->getKeys();
        $promosKeys = $this->promos->getKeys();

        foreach ($productKeys as $sku=>$value) {

            if ($this->promos->keyExists($sku)) {

                $productObj = $this->products->getItem($sku);
                $promoObj = $this->promos->getItem($sku);

                $name = $productObj->getName();
                $basePriceNet = $productObj->getBasePriceNet();
                $minimalPriceNet = $productObj->getMinimalPriceNet();
                $discount = $promoObj->getDiscount();
                $calculatedPriceTaxed = $this->PriceCalculate(
                                                    $basePriceNet,
                                                    $minimalPriceNet,
                                                    $discount
                );
                $this->buildString(
                                $sku,
                                $name,
                                $basePriceNet,
                                $calculatedPriceTaxed
                );
            }
        }
        return $this->result;
    }

    private function PriceCalculate(float $netBase,
                                    float $netMinimal,
                                    float $discount): float {
        // calcluate price
        $tmpPrice = (1 - $discount) * $netBase;
        $tmpPrice = max($tmpPrice, $netMinimal);

        // add tax
        return round($tmpPrice * (1 + self::TAX_PERCENTAGE), 2);
    }

    private function buildString(string $sku,
                                 string $name,
                                 string $priceBefore,
                                 string $priceNow) {

        $str = $sku . self::STRING_SEPARATOR
                . $name . self::STRING_SEPARATOR
                . round($priceBefore * ( 1 + self::TAX_PERCENTAGE), 2) . self::STRING_SEPARATOR
                . $priceNow . self::STRING_SEPARATOR
                . PHP_EOL;
        $this->result = $this->result . $str;
    }
}