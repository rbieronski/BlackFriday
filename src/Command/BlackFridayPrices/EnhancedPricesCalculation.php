<?php

namespace Anguis\BlackFriday\Command\BlackFridayPrices;

use Anguis\BlackFriday\Collection\Collection;
use Anguis\BlackFriday\Entity\BlackFridayPricesEntity;

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
 * Added sort bool parameter to constructor
 */
class EnhancedPricesCalculation
{
    public const STRING_SEPARATOR = ", ";
    public const NEW_LINE_SEPARATOR = PHP_EOL;
    protected const TAX_PERCENTAGE = 23;

    // Entry data sources
    protected Collection $products;
    protected Collection $promos;

    // Should result be sorted
    protected bool $sortResult;

    // Variables to store result:
    //      array $arrResult - temporary, only to use by current class
    //                         in a case of implement method such as sort
    //      string $result - 'external' final result variable
    //                       to use by ShowPricesCommand class
    protected array $arrResult;
    protected string $result = "";


    /**
     * Receive data from two collections
     * @param Collection $products
     * @param Collection $promos
     */
    function __construct(
        Collection $products,
        Collection $promos,
        bool $sortResult = true
    )
    {
        $this->products = $products;
        $this->promos = $promos;
        $this->sortResult = $sortResult;
    }

    public function getResult(): string
    {
        $this->prepareResultArray();
        if ($this->sortResult) {
            $this->sortAscByPriceNowGross();
        }
        return $this->prepareResultString();
    }

    /**
     * main method calculating prices
     * and calling method 'addToResult'
     * for each row calculated
     */
    protected function prepareResultArray()
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

                $discountPriceNet = $this->discountPriceCalculate(
                    $basePriceNet,
                    $minimalPriceNet,
                    $discount
                );

                // prepare result array
                $this->addToResultArray(
                    $sku,
                    $name,
                    $basePriceGross,
                    $discountPriceGross,
                    $basePriceNet,
                    $discountPriceNet,
                    $minimalPriceNet
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

    protected function addTax(float $value): float
    {
        return $value * (1 + 0.01 * self::TAX_PERCENTAGE);
    }

    protected function forceDiscount(float $value, float $discount): float
    {
        return $value * (1 - 0.01 * $discount);
    }

    protected function forceDecimals(float $value): string
    {
        return number_format($value, 2, '.', '');
    }

    protected function addToResultArray(
        string $sku,
        string $name,
        string $priceBeforeGross,
        string $priceNowGross,
        string $priceBeforeNet,
        string $priceNowNet,
        string $minimalPrice
    ) {
        $arr['sku'] = $sku;
        $arr['name'] = $name;
        $arr['priceBeforeGross'] = $priceBeforeGross;
        $arr['priceNowGross'] = $priceNowGross;
        $arr['priceBeforeNet'] = $priceBeforeNet;
        $arr['priceNowNet'] = $priceNowNet;
        $arr['minimalPrice'] =$minimalPrice;
        $this->arrResult[] = $arr;
    }

    protected function prepareResultString(): string
    {
        foreach ($this->arrResult as $item) {
            $this->result = $this->result
                . $item['sku'] . self::STRING_SEPARATOR
                . $item['name'] . self::STRING_SEPARATOR
                . $this->forceDecimals($item['priceBeforeGross']) . self::STRING_SEPARATOR
                . $this->forceDecimals($item['priceNowGross']) . self::STRING_SEPARATOR
                . $this->forceDecimals($item['priceBeforeNet']) . self::STRING_SEPARATOR
                . $this->forceDecimals($item['priceNowNet']) . self::STRING_SEPARATOR
                . $this->forceDecimals($item['minimalPrice']) . self::STRING_SEPARATOR
                . self::NEW_LINE_SEPARATOR;
        }
        return $this->result;
    }

    public function sortAscByPriceNowGross(): array
    {
        $price = array_column($this->arrResult, 'priceNowGross');
        array_multisort($price, SORT_ASC, $this->arrResult);
        return $this->arrResult;
    }

//
//    private function addToResult(
//        string $sku,
//        string $name,
//        string $priceBefore,
//        string $priceNow
//    ) {
//        $str = $sku . self::STRING_SEPARATOR
//            . $name . self::STRING_SEPARATOR
//            . $this->forcePadding($priceBefore) . self::STRING_SEPARATOR
//            . $this->forcePadding($priceNow). self::STRING_SEPARATOR
//            . self::NEW_LINE_SEPARATOR;
//
//        // add result to existing string
//        $this->result = $this->result . $str;
//    }




}
