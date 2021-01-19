<?php

namespace Anguis\BlackFriday\Command\BlackFridayPrices;

use Anguis\BlackFriday\Collection\Collection;

/**
 * Class calculating prices for Black Friday
 * contains business logic
 *
 * @package Anguis\BlackFriday\Command\BlackFridayPrices
 *
 *
 * Due to a new business logic for version 1.1.0
 * added new columns to result string:
 *   -(net) base price before promotion
 *   -(net) discounted price
 *   -(net) minimal price
 *
 * Inheritance using PricesCalculation class was not available
 * because its methods visibility were set to private instead protected/public.
 *
 * In the current class all the private methods were set to protected.
 * The rest of differences compared to PricesCalculation class
 * were marked with additional comment:
 *          //  !* difference to PricesCalculation class *!
 */
class EnhancedPricesCalculation
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
        Collection $promos
    )
    {
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
    protected function prepare()
    {
        $productKeys = $this->products->getKeys();

        foreach ($productKeys as $item => $sku) {

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

                //  !* difference to PricesCalculation class *!
                $discountPriceNet = $this->discountPriceCalculate(
                    $basePriceNet,
                    $minimalPriceNet,
                    $discount
                );

                // prepare result string
                $this->addToResult(
                    $sku,
                    $name,
                    $basePriceGross,
                    $discountPriceGross,
                    $basePriceNet,          //  !* difference to PricesCalculation class *!
                    $discountPriceNet,      //  !* difference to PricesCalculation class *!
                    $minimalPriceNet        //  !* difference to PricesCalculation class *!
                );
            }
        }
    }

    protected function discountPriceCalculate(
        float $basePrice,
        float $minimalPrice,
        float $discount
    ): float
    {
        // no allow to drop price below minimum to avoid making a loss!
        $finalPromoPrice = max(
            $this->forceDiscount($basePrice, $discount),
            $minimalPrice
        );
        return round($finalPromoPrice, 2);
    }

    protected function addToResult(
        string $sku,
        string $name,
        string $priceBeforeGross,
        string $priceNowGross,
        string $priceBeforeNet,             //  !* difference to PricesCalculation class *!
        string $priceNowNet,                //  !* difference to PricesCalculation class *!
        string $minimalPrice                //  !* difference to PricesCalculation class *!
    )
    {
        $str = $sku . self::STRING_SEPARATOR
            . $name . self::STRING_SEPARATOR
            . $this->forcePadding($priceBeforeGross) . self::STRING_SEPARATOR
            . $this->forcePadding($priceNowGross) . self::STRING_SEPARATOR

            //  !* difference to PricesCalculation class *!
            . $this->forcePadding($priceBeforeNet) . self::STRING_SEPARATOR
            . $this->forcePadding($priceNowNet) . self::STRING_SEPARATOR
            . $this->forcePadding($minimalPrice) . self::STRING_SEPARATOR
            //  ---------------------- end of differences

            . self::NEW_LINE_SEPARATOR;

        // add result to existing string
        $this->result = $this->result . $str;
    }

    protected function addTax(float $value): float
    {
        return $value * (1 + 0.01 * self::TAX_PERCENTAGE);
    }

    protected function forceDiscount(float $value, float $discount): float
    {
        return $value * (1 - 0.01 * $discount);
    }

    protected function forcePadding(float $value): string
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
