<?php


namespace Anguis\BlackFriday\Command\BlackFridayPrices;


interface PricesCalculationInterface
{
    public function getResult(): string;
}