<?php

namespace Anguis\BlackFriday\Command\BlackFridayPrices;


use Anguis\BlackFriday\Collection\Collection;


class PricesCalculation
{
    const STRING_SEPARATOR = ", ";
    const TAX_PERCENTAGE = 23;


    protected Collection $products;
    protected Collection $promos;
    protected string $result = "";


    function __construct(
                Collection $products,
                Collection  $promos
    ) {
        $this->products = $products;
        $this->promos = $promos;
    }

    public function getResult(): string
    {
        $this->prepare();
        return $this->result;
    }

    /**
     *  contains business logic
     */
    public function prepare()
    {
        $productKeys = $this->products->getKeys();

        foreach ($productKeys as $item=>$sku) {

            // proceed only if match exists
            if ($this->promos->keyExists($sku)) {

                // get array values
                $productObj = $this->products->getItem($sku);
                $promoObj = $this->promos->getItem($sku);

                // set row variables
                $name = $productObj->getName();
                $basePriceNet = $productObj->getBasePriceNet();
                $minimalPriceNet = $productObj->getMinimalPriceNet();
                $discount = $promoObj->getDiscount();
                $calculatedPriceTaxed = $this->PriceCalculate(
                    $basePriceNet,
                    $minimalPriceNet,
                    $discount
                );

                // prepare result string
                $this->addToResult(
                    $sku,
                    $name,
                    $basePriceNet,
                    $calculatedPriceTaxed
                );
            }
        }
    }

    private function priceCalculate(
            float $netBase,
            float $netMinimal,
            float $discount
        ): float {

        // no allow to drop price below minimum!
        return max(
            $this->forceDiscount($netBase, $discount),
            $netMinimal
        );
    }

    private function addToResult(string $sku,
                                 string $name,
                                 string $priceBefore,
                                 string $priceNow) {

        $str = $sku . self::STRING_SEPARATOR
                . $name . self::STRING_SEPARATOR
                . $this->forceDecimals(
                    $this->RoundPrice($this->AddTax($priceBefore))
                    ) . self::STRING_SEPARATOR
                . $this->forceDecimals(
                    $priceNow
                    ) . self::STRING_SEPARATOR
                . PHP_EOL;

        // add result to existing string
        $this->result = $this->result . $str;
    }

    private function roundPrice(float $value): float
    {
        return round($value, 2);
    }

    private function addTax(float $value): float
    {
        return $value * ( 1 + self::TAX_PERCENTAGE);
    }

    private function forceDiscount(float $value, float $discount): float
    {
        return $value * (1 - $discount);
    }

    private function forceDecimals(float $value): string
    {
        return number_format($value, 2, '.', ' ');
    }
}