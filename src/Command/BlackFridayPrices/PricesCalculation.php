<?php

namespace Anguis\BlackFriday\Command\BlackFridayPrices;

use Anguis\BlackFriday\Collection\Collection;

/**
 * Class calculating prices for Black Friday
 * contains business logic
 *
 * @package Anguis\BlackFriday\Command\BlackFridayPrices
 */
class PricesCalculation implements PricesCalculationInterface
{
    public const STRING_SEPARATOR = ", ";
    public const NEW_LINE_SEPARATOR = PHP_EOL;
    protected const TAX_PERCENTAGE = 23;

    // entry data sources
    protected Collection $products;
    protected Collection $promos;

    // variable to store result
    protected string $result = "";

    /**
     * Receive data from two collections
     * @param Collection $products
     * @param Collection $promos
     */
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
     * main method calculating prices
     * and calling method 'addToResult'
     * for each row calculated
     */
    private function prepare()
    {
        $productKeys = $this->products->getKeys();

        foreach ($productKeys as $item=>$sku) {

            // proceed only if match exists
            if ($this->promos->keyExists($sku)) {

                // get array values
                $productObj = $this->products->getItem($sku);
                $promoObj = $this->promos->getItem($sku);

                // get values from objects
                $name = $productObj->getName();
                $basePriceNet = $productObj->getBasePriceNet();
                $minimalPriceNet = $productObj->getMinimalPriceNet();
                $discount = $promoObj->getDiscount();

                // recalculate prices
                $basePriceGross = $this->addTax($basePriceNet);
                $minimalPriceGross = $this->addTax($minimalPriceNet);
                $discountPriceGross = $this->discountPriceCalculate(
                    $basePriceGross,
                    $minimalPriceGross,
                    $discount
                );

                // prepare result string
                $this->addToResult(
                    $sku,
                    $name,
                    $basePriceGross,
                    $discountPriceGross
                );
            }
        }
    }

    private function discountPriceCalculate(
        float $basePrice,
        float $minimalPrice,
        float $discount
    ): float {
        // no allow to drop price below minimum to avoid making a loss!
        $finalPromoPrice = max(
            $this->forceDiscount($basePrice, $discount),
            $minimalPrice
        );
        return round($finalPromoPrice, 2);
    }

    private function addToResult(
        string $sku,
        string $name,
        string $priceBefore,
        string $priceNow
    ) {
        $str = $sku . self::STRING_SEPARATOR
            . $name . self::STRING_SEPARATOR
            . $this->forcePadding($priceBefore) . self::STRING_SEPARATOR
            . $this->forcePadding($priceNow). self::STRING_SEPARATOR
            . self::NEW_LINE_SEPARATOR;

        // add result to existing string
        $this->result = $this->result . $str;
    }

    private function addTax(float $value): float
    {
        return $value * ( 1 + 0.01 * self::TAX_PERCENTAGE);
    }

    private function forceDiscount(float $value, float $discount): float
    {
        return $value * (1 - 0.01 * $discount);
    }

    private function forcePadding(float $value): string
    {
        // ToDo: add padding depending on 'cells' length
        return str_pad(
            number_format($value, 2, '.', ' '),
            15,
            " ",
            STR_PAD_LEFT
        );
    }
}