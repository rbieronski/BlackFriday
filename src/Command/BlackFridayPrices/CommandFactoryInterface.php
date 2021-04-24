<?php

namespace Anguis\BlackFriday\Command\BlackFridayPrices;

interface CommandFactoryInterface
{
    public function create(bool $sort): ShowPricesCommand;
}